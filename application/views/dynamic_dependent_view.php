

<html>
<head>
    <title> My View </title>
    <link rel="stylesheet" href="../../../my_boots/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../my_boots/css/bootstrap-theme.css">
    <script src="../../../my_boots/jquery-3.6.0.js"></script>
    <style>
        .box{
            width:100%
            max-width: 650px;
            margin: 0 auto;
        }
    
    </style>
</head>    
<body>
<div class = "container box">
    <br /><br />
    <h3 style = "align: center"> Dynamic Dependent Selection</h3><br />
          
            <div class = "form-group">
                <select name="state" id="state" class = "form-control input-lg">
                <option value="">Select State</option>
                </option>
                <?php
                foreach($state as $row){
                    echo '<option value="'.$row->id.'">'.$row->state.'</option>';
                }
                ?>
                </select>
            </div>
</div>

<script src="../../../my_boots/js/bootstrap.js"></script>
<script src="../../../my_boots/js/bootstrap.min.js"></script>
</body>
</html>
