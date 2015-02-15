<?php
/*
**************************************
******PHP Runner 1.0.1****************
******Created by Harish U Warrier*****
******Created on 23-01-2015***********
******Modified on 14-02-2014**********
******phprunner@jformslider.com*******
******php.jformslider.com*************
**************************************
*/
$langc='p';
if(isset($_POST['code'])){
    if($_POST['lang']=='p'){
            file_put_contents('test.php', '<?php '.$_POST['code'].' ?>');
    }else if($_POST['lang']=='h'){
            file_put_contents('test.php', $_POST['code']);
    }else if($_POST['lang']=='m'){

    }
    include_once('test.php');
    exit;
}
if(isset($_POST['lang'])){
    $langc=$_POST['lang'];
}
if(isset($_GET['function'])){
    $g=trim($_GET['function']);
    call_user_func($g);
    exit;
}
function save(){
    if(!is_dir('files')){mkdir('files');}
    if(!is_dir('files/'.trim($_POST['type']))){
        mkdir('files/'.trim($_POST['type']));
    }
    $my_file = 'files/'.trim($_POST['type']).'/'.trim($_POST['file']);
    if(file_exists($my_file)){
        echo"d";
    }else{
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        $data = trim($_POST['data']);
        fwrite($handle, $data);
    }
}
function update(){
    $my_file = 'files/'.trim($_POST['type']).'/'.trim($_POST['file']);
    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
    $data = trim($_POST['data']);
    fwrite($handle, $data);
}
function delete(){
    unlink('files/'.trim($_POST['file']));
}
function view(){
    echo file_get_contents('files/'.trim($_POST['fname']));
}
function download(){
    $file=isset($_GET['file'])?$_GET['file']:"";
    $type=isset($_GET['type'])?$_GET['type']:"";
    
    if(file_exists("files/".$file) && is_file("files/".$file))
    {
        $filename=  explode('/', $file);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$filename[count($filename)-1].".".$type);
        if($type=="php"){
            echo"<?php ".file_get_contents("files/".$file)." ?>";
        }else{
           readfile("files/".$file);
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title data-start="5000">PHP runner v 1.0.1 Test and run your php,html,javascripts etc</title>
        <link href="scripts/bootstrap.min.css" rel="stylesheet"/>
         <style type="text/css">
        .just_hide{
            display:none;
        }
        .container{
            margin-left: 0px !important;
        }
        .btn-circle{
            border-radius: 50px !important;
        }
        .navbar-default .navbar-nav>li>a:hover{
            color: #555;
            background-color: #e7e7e7 !important;
        }
        
        </style>
        <script src="scripts/jTitleScroller.min.js"></script>
        <script src="scripts/jquery-2.0.3.min.js"></script>
        <script src="scripts/bootstrap.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">PHP Runner</a>
            </div>
            <div>
              <ul class="nav navbar-nav">
                <li class=""><a href="#" data-toggle="modal" data-target="#about_us">Help</a></li>
                <li><a href="#" id="phpinfo">PHP info</a></li>
                <li><a href="#" data-toggle="modal" data-target="#notify_me">Notify me</a></li>
                <li><a href="#" data-toggle="modal" data-target="#text_length">Text Length</a></li>
                <li><a href="http://jformslider.com"  target="_blank">jFormslider Plugin</a></li>
              </ul>
            </div>
          </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <form method="post" class="" role="form" id="runner_form">
                        <div class="form-group">
                            <select id="selectcode" class="form-control">
                                <option value='-1'>Saved Codes</option>
                                <?php
                                if(is_dir('files/html')){
                                    $scd=scandir('files/html');
                                    for($i=2;$i<count($scd);$i++){?>
                                        <option data-type="html" value="<?=$scd[$i]?>"><?=$scd[$i]?></option>
                                <?php }}if(is_dir('files/php')){
                                    $scd=scandir('files/php');
                                    for($i=2;$i<count($scd);$i++){?>
                                        <option data-type="php" value="<?=$scd[$i]?>"><?=$scd[$i]?></option>
                                <?php }}?>
                           </select>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="p" data-type="php" name="lang" <?php if($langc=='p') echo'checked="checked"';?>/>PHP </label>&nbsp;&nbsp;
                            <label><input type="radio" value="h" data-type="html" name="lang" <?php if($langc=='h') echo'checked="checked"';?>/>HTML</label>
                            <a class="btn btn-primary btn-xs" onclick="$('#runner_form')[0].reset();"><i class="glyphicon glyphicon-record"></i> Reset</a>
                            <button class="btn btn-success btn-xs" type="submit" value="1" ><i class="glyphicon glyphicon-play"></i> Run  </button>
                            <a class="btn btn-success btn-xs" id="savefile" data-placement="bottom"><i class="glyphicon glyphicon-floppy-disk"></i> Save</a><br/>
                            
                        <a class="btn btn-info btn-xs just_hide file_actions" data-loaing-text="Updating..." id="updatefile"><i class="glyphicon glyphicon-floppy-saved"></i> Update</a>
                        <a class="btn btn-danger btn-xs just_hide file_actions" data-toggle="modal" data-target="#delete_confirm">
                        <i class="glyphicon glyphicon-trash  " style="cursor:pointer"/></i> Delete
                        </a> &nbsp;
                        
                        <a href="" id="download_file" class="btn btn-default btn-xs just_hide file_actions"> 
                        <i class="glyphicon glyphicon-download  " style="cursor:pointer"/></i> Download
                        </a>
                        </div>
                        <textarea class="form-control" name="test" id="type" rows="30" cols=50">
                            <?php if(isset($_POST['test'])){
                                    echo trim($_POST['test']);
                                  }?>
                        </textarea>
                        
                        
                    </form>
                </div>
                <div class="col-md-8" id="result">
                    <?php
                    if(isset($_POST['test'])){
                            if($_POST['lang']=='p'){
                                    file_put_contents('test.php', '<?php '.$_POST['test'].' ?>');
                            }else if($_POST['lang']=='h'){
                                    file_put_contents('test.php', $_POST['test']);
                            }
                    }
                    include_once('test.php');
                    ?>
                </div>
            </div>
        </div>
        <!--modals-->
        <div class="modal fade" id="delete_confirm">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="text-center" style="font-size: bold">
                        Are you sure you want to delete <br/> <span id="del_fname"></span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-xs" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
                    <button data-loading-text="Deleting..." onclick="delete_file($(this));" type="button" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                </div>
              </div>
            </div>
        </div>
        <!--modals-->
        <!--modals notify-->
        <div class="modal fade" id="notify_me">
            <div class="modal-dialog ">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4><strong>Notify Me</strong></h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label>Message:</label>
                            <input type="text" class="form-control" id="nort_msg" placeholder="Enter your message">
                        </div>
                         <div class="form-group">
                            <label>Notify in:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="nort_time">
                                <span class="input-group-addon">Minutes</span>
                            </div>
                        </div>
                         <div class="form-group">
                            <label>Type:</label>
                            <div class="radio">
                                <label><input type="radio" name="nort_type" value="desk" checked="">Desktop notification</label>
                                <label><input type="radio" name="nort_type" value="alert" >Alert</label>
                                <span style="margin-left: 40px;"></span>
                                <a class="btn btn-success" id="nort_prev"><i class="glyphicon glyphicon-search"></i> Preview</a>
                                <a class="btn btn-primary" id="nort_me"><i class="glyphicon glyphicon-bell"></i> Notify</a>
                                <p class="help-block text-danger">In case any incompatibility it will default to alert</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <span class="text-info pull-left"><i class="glyphicon glyphicon-exclamation-sign"></i> If browser window is closed this won't work</span>
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                </div>
              </div>
            </div>
        </div>
        <!--modals notify-->
         <!--modals textlength-->
           <div class="modal fade" id="text_length">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4>Text Length</h4>
                </div>
                <div class="modal-body">
                    <textarea rows="5" id="length_finder" class="form-control" placeholder="Enter text"></textarea>
                    <p class="help-block">Length: <span id="length_result"  style="color: green;font-weight: bold"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                </div>
              </div>
            </div>
        </div>
        <!--modals textlength-->
          <!--modals about-->
           <div class="modal fade" id="about_us">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Help</h4>
                </div>
                <div class="modal-body">
                    <p>
                        To Test code enter your code in textarea and blur or click run <br/>
                    </p>
                    <p>Available options are save,download,delete codes</p>
                    <p>Other options are phpinfo,textlength finder and nortifier</p>
                    <p>Report Bugs and suggestions to phprunner@jformslider.com</p>
                    <p>
                        Php Runner is developed by Harish U Warrier<br/>
                        Email:harish@jformslider.com<br/>
                        
                        Website:<a href="http://jformslider.com" target="_blank">jformslider.com</a>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
                </div>
              </div>
            </div>
        </div>
        <!--modals about-->
        <script src="scripts/tools.js"></script>
         <footer class="footer">
      <div class="container">
        <p class="text-muted"></p>
      </div>
    </footer>
    </body>
</html>
