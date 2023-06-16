<?php
class Proma_model extends CI_Model{
   
    function create_client($data=NULL){
        if ($data){
            $this->db->insert('clients', $data);
        }
        return $this->db->get('clients')->result();
    }

    function create_template($template){
        // $template keys: title, desc, file, tasks, tasksFile
        // template columns: id, title, notes, file
        $t = array(
            'id' => uniqid(),
            'title' => $template['title'],
            'notes' => $template['desc'],
            'file' => $template['files']["temp_file"]
        );
        
        $this->db->insert('templates', $t);

        // $task keys: title, desc, duration, unit, texts, longs, files, boxes, radios
        // task columns: id, templateId, notes, title, duration, unit, texts, longs, files, boxes, radios, file
        $tasks = [];
        $i = 0;
        foreach ($template['tasks'] as $task){
            $arr = array(
                'id' => uniqid(),
                'templateId' => $t['id'],
                'notes' => $task['desc'],
                'title' => $task['title'],
                'duration' => $task['duration'],
                'unit' => $task['unit'],
                'file' => $template['files'][$task['title'].$task['duration']],
                'texts' => implode('<>', $task['texts']),
                'longs' => implode('<>', $task['longs']),
                'files' => implode('<>', $task['files']),
                'boxes' => implode('<>', $task['boxes']),
                'radios' => implode('<>', $task['radios'])
            );
            $i++;
            array_push($tasks, $arr);
            unset($arr);
            // do multiple inserts
        }
        if ($tasks != []){
            $this->db->insert_batch('tasks', $tasks);
        }
        return 'success';
        // insert tasks

    }

    function create_job($job){
        $j = array(
            'id' => uniqid(),
            'title' => $job['title'],
            'notes' => $job['desc'],
            'clientId' => $job['client'],
            'file' => $job['files']["job-file"]
        );
        
        $this->db->insert('jobs', $j);

        $tasks = [];
        $i = 0;
        //'title': title, 'dur': dur, 'unit': unit, 'sdate': sdate, 'edate': edate, 'deps': deps};
        foreach ($job['tasks'] as $task){
            $arr = array(
                'id' => uniqid(),
                'jobId' => $j['id'],
                'notes' => $task['desc'],
                'title' => $task['title'],
                'start_date' => $task['sdate'],
                'end_date' => $task['edate'],
                'duration' => $task['dur'],
                'unit' => $task['unit'],
                'prev_tasks' => implode('<>', $task['deps']),
                'file' => $job['files'][$task['title'].$task['dur'].$task['unit']],
                'texts' => implode('<>', $task['texts']),
                'longs' => implode('<>', $task['longs']),
                'files' => implode('<>', $task['files']),
                'boxes' => implode('<>', $task['boxes']),
                'radios' => implode('<>', $task['radios'])
            );
            $i++;
            array_push($tasks, $arr);
            unset($arr);
        }

        // do multiple inserts
        if ($tasks != []){
            $this->db->insert_batch('tasks', $tasks);
        }
        return 'success';

    }

    public function fetch_templates(){
        $temps = $this->db->get('templates')->result();
        $out = array();
        foreach ($temps as $row){
            $out[$row->id]['tasks'] = $this->db->select('title')->where('templateId', $row->id)->get('tasks')->result();
            $out[$row->id]['title'] = $row->title;
            $out[$row->id]['notes'] = $row->notes;
            $out[$row->id]['file'] = $row->file;
        }
        return $out;
    }

    public function fetch_template($id){
        $tasks = $this->db->where('templateId', $id)->get('tasks')->result();
        $temp = $this->db->where('id', $id)->get('templates')->result();
        $clients = $this->db->select('id, fullname')->get('clients')->result();
        return array('temp'=>$temp, 'tasks'=>$tasks, 'clients'=>$clients);
    }

    public function fetch_jobs(){
        $jobs = $this->db->where('status', 'started')->get('jobs')->result();
        $tasks = $this->db->where('status', 'started')->get('tasks')->result();
        return array('jobs'=> $jobs);
    }

    public function get_tasks($id, $c_id) {
        $all = $this->db->where('jobId',$id)->count_all_results('tasks');
        $done = $this->db->where(array('jobId'=>$id, 'status'=>'done'))->count_all_results('tasks');
        $date = $this->db->select_max('end_date')->where('jobId', $id)->get('tasks')->result();
        $client = $this->db->where('id', $c_id)->select('fullname')->get('clients')->row();
        return array('all'=>$all, 'done'=>$done, 'date'=> $date, 'client'=> $client);

    }

    public function get_job($id) {
        $tasks = $this->db->where('jobId', $id)->get('tasks')->result();
        $job = $this->db->where('id', $id)->get('jobs')->row();
        $client = $this->db->select('fullname')->where('id', $job->clientId)->get('clients')->result();
        return array('job'=>$job, 'tasks'=>$tasks, 'client'=>$client);
    }

    public function update_job($job){
        /*     {"files":{"64877d3ac0ecf_file2":"create_template_snippet33.jpg"},
        "tasks":[{"texts":{"text1":"","text2":""},"longs":{"long1":"","long2":""},"boxes":{},"radios":{},"id":"64877d3ac0ea8"},
                {"texts":{"text1":"","text2":""},"longs":{"long1":"","long2":""},"boxes":{},"radios":{},"id":"64877d3ac0ecf"}],
                "id":"64877d3ac0721"} */
        $files = $job['files'];
        $group = array();
        foreach($files as $name=>$file){
            if (!count($group)){
                array_push($group, $name.'_'.$file);
            } else if (explode('_', $group[0])[0] == explode('_', $name)[0]){
                array_push($group, $name.'_'.$file);
            }else{
                $this->store_group($group);
                $group = array($name);
            }
        }
        
        foreach ($job['tasks'] as $task){
            $id = $task['id'];
            $texts=$task['texts'];
            $tvalues = $this->db->select('titles')->where('taskId', $id)->get('textinputs')->result();
            if (count($tvalues)){
                $this->db->where('taskId', $id)->set('titles', ($tvalues[0]->titles).'<>'.(implode('<>', $group)))->update('files');
            } else {
                $data = array(
                'id' => uniqid(),
                'taskId' => explode('_', $group[0])[0],
                'titles' => implode('<>', $group)
                );
                $this->db->insert('textinputs', $data);
            }
            $longs = $task['longs'];
            $boxes = $task['boxes'];
            $radio = $task['radios'];
        }

        return 'success';
    }

    function store_group($group){
        $values = $this->db->select('titles')->where('taskId', explode('_', $group[0])[0])->get('files')->result();
        if (count($values)){
            $this->db->where('taskId', explode('_', $group[0])[0])->set('titles', ($values[0]->titles).'<>'.(implode('<>', $group)))->update('files');
        } else {
            $data = array(
                'id' => uniqid(),
                'taskId' => explode('_', $group[0])[0],
                'title' => implode('<>', $group)
            );
            $this->db->insert('files', $data);
        }
    }

    public function client_jobs($id){
        $jobs = $this->db->where('clientId', $id)->get('jobs')->result();
        $name = $this->db->where('id', $id)->select('fullname')->get('clients')->row();
        return array('jobs'=> $jobs, 'name'=>$name);
    }
}
?>