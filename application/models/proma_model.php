<?php
class Proma_model extends CI_Model{
   
    function create_client($email, $data=NULL){
        
        if ($data){
            $data['userId'] = $this->get_user_id($email);
            $this->db->insert('clients', $data);
        }
        return $this->db->where('userId', $this->get_user_id($email))->get('clients')->result();
    }

    function create_template($template){
        // $template keys: title, desc, file, tasks, tasksFile
        // template columns: id, title, notes, file
        $email = $this->session->userdata('user_email');
        $t = array(
            'id' => uniqid(),
            'userId' => $this->get_user_id($email),
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
        $email = $this->session->userdata('user_email');
        $j = array(
            'id' => uniqid(),
            'title' => $job['title'],
            'notes' => $job['desc'],
            'clientId' => $job['client'],
            'userId' => $this->get_user_id($email),
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

    public function fetch_templates($email){
        $user_id = $this->get_user_id($email);
        $temps = $this->db->where('userId', $user_id)->get('templates')->result();
        $out = array();
        foreach ($temps as $row){
            $out[$row->id]['tasks'] = $this->db->select('title')->where('templateId', $row->id)->get('tasks')->result();
            $out[$row->id]['title'] = $row->title;
            $out[$row->id]['notes'] = $row->notes;
            $out[$row->id]['file'] = $row->file;
        }
        return $out;
    }
    function get_user_id($mail){
        $user_id = $this->db->where('email', $mail)->select('id')->get('users')->row();
        return $user_id->id;
    }
    public function fetch_template($id){
        $tasks = $this->db->where('templateId', $id)->get('tasks')->result();
        $temp = $this->db->where('id', $id)->get('templates')->result();
        $clients = $this->db->select('id, fullname')->get('clients')->result();
        return array('temp'=>$temp, 'tasks'=>$tasks, 'clients'=>$clients);
    }

    public function fetch_jobs($email, $done=false){
        $u_id = $this->get_user_id($email);
        if ($done){
            $jobs = $this->db->where('userId', $u_id)->where('status', 'done')->get('jobs')->result();
            return array('jobs'=> $jobs);    
        }
        $jobs = $this->db->where('userId', $u_id)->where('status', 'started')->get('jobs')->result();
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
        $input = $this->get_input($tasks);
        $job = $this->db->where('id', $id)->get('jobs')->row();
        $client = $this->db->select('fullname')->where('id', $job->clientId)->get('clients')->result();
        return array('input'=>$input, 'job'=>$job, 'tasks'=>$tasks, 'client'=>$client);
    }

    function get_input($tasks){
        $out = [];
        foreach ($tasks as $row){
            $texts = $this->db->where('taskId', $row->id)->select('titles')->get('textinputs')->row();
            $longs = $this->db->where('taskId', $row->id)->select('titles')->get('textareas')->row();
            $boxes = $this->db->where('taskId', $row->id)->select('titles')->get('checklists')->row();
            $radios = $this->db->where('taskId', $row->id)->select('titles')->get('radiobuttons')->row();
            $files = $this->db->where('taskId', $row->id)->select('titles')->get('files')->row();
            $out[$row->id] = [$texts, $longs, $boxes, $radios, $files];
        }
        return $out;
    }
    public function update_job($job){
        //tl;dr
        //store files of same task
        $files = $job['files'];
        $group = array();
        foreach($files as $name=>$file){
            if (!count($group)){
                array_push($group, $name.':'.$file);
            } else if (explode(':', $group[0])[1] == explode('_', $name)[1]){
                array_push($group, $name.':'.$file);
            }else{
                $this->store_group($group);
                $group = array($name.':'.$file);
            }
        }
        if (count($files) == 1){
            $this->store_group($group);
        }
        if(array_key_exists('job_done', $job)){
            $this->db->where('id', $job['id'])->set('status', 'done')->update('jobs');
        }
        //update tasks
        foreach ($job['tasks'] as $task){
            $id = $task['id'];
            $texts=$task['texts'];
            $tvalues = $this->db->select('titles')->where('taskId', $id)->get('textinputs')->result();
            if (count($tvalues)){
                $this->db->where('taskId', $id)->set('titles', ($tvalues[0]->titles).'<>'.$this->mash($texts))->update('textinputs');
            } else {
                $data = array(
                'id' => uniqid(),
                'taskId' => $task['id'],
                'titles' => $this->mash($texts)
                );
                $this->db->insert('textinputs', $data);
            }
            $longs = $task['longs'];
            $lvalues = $this->db->select('titles')->where('taskId', $id)->get('textareas')->result();
            if (count($lvalues)){
                $this->db->where('taskId', $id)->set('titles', ($lvalues[0]->titles).'<>'.$this->mash($longs))->update('textareas');
            } else {
                $data = array(
                'id' => uniqid(),
                'taskId' => $task['id'],
                'titles' => $this->mash($longs)
                );
                $this->db->insert('textareas', $data);
            }
            $boxes = $task['boxes'];
            $bvalues = $this->db->select('titles')->where('taskId', $id)->get('checklists')->result();
            if (count($bvalues)){
                $this->db->where('taskId', $id)->set('titles', ($bvalues[0]->titles).'<>'.implode('<>', array_keys($boxes)))->update('checklists');
            } else {
                $data = array(
                'id' => uniqid(),
                'taskId' => $task['id'],
                'titles' => implode('<>', array_keys($boxes))
                );
                $this->db->insert('checklists', $data);
            }
            $radios = $task['radios'];
            $rvalues = $this->db->select('titles')->where('taskId', $id)->get('radiobuttons')->result();
            if (count($rvalues)){
                $this->db->where('taskId', $id)->set('titles', ($rvalues[0]->titles).'<>'.implode('<>', array_keys($radios)))->update('radiobuttons');
            } else {
                $data = array(
                'id' => uniqid(),
                'taskId' => $task['id'],
                'titles' => implode('<>', array_keys($radios))
                );
                $this->db->insert('radiobuttons', $data);
            }
            if(array_key_exists($id, $task)){
                $this->db->where('id', $id)->set('status', 'done')->update('tasks');
            }
        }
        return 'success';
    }

    function store_group($group){
        $values = $this->db->select('titles')->where('taskId', explode('_', explode(':', $group[0])[0])[1])->get('files')->result();
        if (count($values)){
            $this->db->where('taskId', explode('_', $group[0])[1])->set('titles', ($values[0]->titles).'<>'.(implode('<>', $group)))->update('files');
        } else {
            $data = array(
                'id' => uniqid(),
                'taskId' => explode('_', explode(':', $group[0])[0])[1],
                'titles' => implode('<>', $group)
            );
            $this->db->insert('files', $data);
        }
    }

    public function client_jobs($id){
        $jobs = $this->db->where('clientId', $id)->get('jobs')->result();
        $name = $this->db->where('id', $id)->select('fullname')->get('clients')->row();
        return array('jobs'=> $jobs, 'name'=>$name);
    }

    function mash($items){
        $out = [];
        foreach($items as $k=>$v){
            if ($v){
                $unit = $k.'_'.$v;
                array_push($out, $unit);
            }
        }
        return implode('<>', $out);
    }

    public function delete_client($id){
        $this->db->where('id', $id)->delete('clients');
        $this->db->where('clientId', $id)->set('clientId', '')->update('jobs');
    }
    
    public function delete_template($id){
        $this->db->where('id', $id)->delete('templates');
        $this->db->where('templateId', $id)->set('templateId', '')->update('tasks');
    }
    
    public function create_user($email, $pword){
        $c = $this->db->where('email', trim($email))->count_all_results('users');
        if ($c){
            return 'invalid';
        }
        $this->db->insert('users', array('id'=>uniqid(), 'email'=>trim($email), 'pword'=>$pword));
        return 'success';
    }

    public function log_in($email, $pword){
        $user = $this->db->where('email', trim($email))->where('pword', md5(trim($pword)))->count_all_results('users');
        if ($user){
            return $user;
        }
        return $user;
    }
}
?>