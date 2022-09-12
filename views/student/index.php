<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use app\models\Student;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> -->

<div class="student-index">

    <h1><?php
    // echo Html::encode($this->title);
    ?></h1>

    <p>
        <?php

        // echo Html::a('Create Student', [
        // 'create'
        // ], [
        // 'class' => 'btn btn-success'
        // ]);
        ?>
    </p>

    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php

    // echo GridView::widget([
    // 'dataProvider' => $dataProvider,
    // // 'filterModel' => $searchModel,
    // 'columns' => [
    // // [
    // // 'class' => 'yii\grid\SerialColumn'
    // // ],
    // 'id',
    // 'name',
    // 'fees',
    // 'email:email',
    // 'profile_pic',
    // [
    // 'class' => ActionColumn::className(),
    // 'urlCreator' => function ($action, $model, $key, $index, $column) {
    // return Url::toRoute([
    // $action,
    // 'id' => $model->id
    // ]);
    // }
    // ]
    // ]
    // ]);

    ?>
    <!-- Button trigger modal -->
<button type="button" onclick="makeFieldsEmpty()" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
 Create Student
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="student-form">

    <?php
    if (empty($model)) {
        $model = new Student();
    }

    // $form = ActiveForm::begin();
    // $form = \yii\widgets\ActiveForm::begin([
    // 'action' => '#'
    // ], [
    // 'options' => [
    // 'enctype' => 'multipart/form-data'
    // ]
    // ]);
    ?>

<form id="w0" action="#" >


<div class="form-group">
<label for="">Name</label>
    <?php
    echo Html::activeHiddenInput($model, 'id', [
        'class' => 'id'
    ]);

    echo Html::activeInput('text', $model, 'name', [
        'class' => 'form-control name',
        'required' => 'required'
    ]);

    ?>
</div>

<div class="form-group">
<label for="">Fees</label>
    <?php

    echo Html::activeInput('number', $model, 'fees', [
        'class' => 'form-control fees',
        'required' => 'required'
    ]);
    ?>
</div>

<div class="form-group">
<label for="">Email</label>
    <?php

    echo Html::activeInput('email', $model, 'email', [
        'class' => 'form-control email',
        'required' => 'required'
    ]);

    ?>
</div>

<div class="form-group">
<label for="">Profile Pic</label>
    <?php

    // echo Html::activeInput('text', $model, 'profile_pic', [
    // 'class' => 'form-control profile_pic',
    // 'required' => 'required'
    // ]);

    // echo Html::activeFileInput($model, 'profile_pic', [
    // 'class' => 'form-control profile_pic',
    // 'required' => 'required'
    // ]);

    ?>
<input type="file" id="student-profile_pic" class="form-control profile_pic" name="Student[profile_pic]" required="required">

</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       <?=Html::submitButton('Save', ['class' => 'btn btn-success btn-save'])?>
       <?php

    // \yii\widgets\ActiveForm::end();

    ?>
    </div>

    </form>

      </div>
    </div>
  </div>
</div>
<br><br><br>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Fees</th>
      <th scope="col">Email</th>
      <th scope="col">Profile Pic</th>
      <th scope="col">Operations</th>
    </tr>
  </thead>
  <tbody id="tbody-i">
  <?php
foreach ($dataProvider as $index => $data) {
    ?>

    <tr id="refresh-<?=$data->id?>">
      <th scope="row"><?=$data->id?></th>
      <td><?=$data->name?></td>
      <td><?=$data->fees?></td>
      <td><?=$data->email?></td>
       <td><?=$data->profile_pic?></td>
        <td>
        <button type="button" id="<?=$data->id?>" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="updateClickId()">
 Update
</button>
        <button type="button" class="btn btn-danger" id="<?=$data->id?>" onclick="DeleteClickID()">Delete</button>
        </td>
    </tr>

<?php
}
?>
  </tbody>
</table>

</div>

<script>


function DeleteClickID() {
    id = event.target.id;
    if(confirm('Are you surely wanna delete this Student ?')){
    	$.ajax({
  		  url: '<?=Url::toRoute(['student/delete'])?>',
  		  data: {
  			  Student:{id:id}
  		  },
  		  type: 'POST',
  		  dataType: 'json',
  		  success: function(response) {
  			  if(response.status == 'OK'){
  				  location.reload(true);
  			}
  		  },
  		  error: function(response) {
  				 alert('Error while deleting data.....');
  		  }
  		});
        }
    else {
			return false;
        }
}

function makeFieldsEmpty(){
	id = $('.id').val('');
	$('.name').val('');
	  $('.fees').val('');
	  $('.email').val('');
	  $('.profile_pic').val('');
}

function updateClickId(){
	id = event.target.id;
	$.ajax({
		  url: '<?=Url::toRoute(['student/update'])?>',
		  data: {
			  Student:{id:id}
		  },
		  type: 'POST',
		  dataType: 'json',
		  success: function(response) {
			  name = response.student.name;
			  fees = response.student.fees;
			  email = response.student.email;
			  profilePic = response.student.profile_pic;
			  $('.id').val(id);
			  $('.name').val(name);
			  $('.fees').val(fees);
			  $('.email').val(email);
			  $('.profile_pic').val(profilePic);
		  },
		  error: function(response) {
				 alert('Error while inserting data.....');
		  }
		});

}

function uploadFile(fname){
  var returnFlag = '';
  var fd = new FormData();
                var files = $('#student-profile_pic')[0].files[0];
                // Student[profile_pic]

                fd.append('file', files);

                $.ajax({
                    url: '<?=Url::toRoute(['student/upload-file'])?>?fName='+fname,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    async: false,
                    success: function(response){
                        if(response.status == 'OK'){
                            alert('sai hai tu...');
                          return returnFlag = response.location;
                        }
                        else
                        {
                          return false;
                        }
                       
                    },
                });
 return returnFlag;               
}


$(".btn-save").click(function() {

  
  var name = $('.name').val();
  var profilePic = uploadFile(name);

var id = $('.id').val();

var fees = $('.fees').val();
var email = $('.email').val();
// var profilePic = $('.profile_pic').val();

alert('fir se sai hai tu....');
// var profilePic = fd;
// var profilePic = document.getElementById("student-profile_pic").files[0];





if(name.length < 1 || fees.length < 1 || email.length < 1 || profilePic.length < 1 )
{
	  return alert('Field is required');
}




	$.ajax({
		  url: '<?=Url::toRoute(['student/index'])?>',
		  data: {
			  Student:{id:id,name:name,fees:fees,email:email,profile_pic:profilePic}
		  },
// 		  data:  new FormData(this),
		  // enctype: 'multipart/form-data',
      // contentType: false,
      // processData: false,
		  type: 'POST',
		  dataType: 'json',
		  async: false,
		  success: function(response) {

			  if(response.status == 'OK'){


				  $("#tbody-i").empty();

				  refreshDiv();

					$(".close").click();
        	}
		  },
		  error: function(response) {
				 alert('Error while inserting data.....');
				 window.stop();
		  }
		});
	return false;
});

function refreshDiv(){
	$.ajax({
		  url: '<?=Url::toRoute(['student/reload-table'])?>',
		  type: 'POST',
		  dataType: 'json',
		  async: false,
		  success: function(response) {

			  if(response.status == 'OK'){

				console.log(response.allData);
				$("#tbody-i").append(response.allData);

					return true;
      			}
		  },
		  error: function(response) {
				 alert('Error while inserting data.....');
				 window.stop();
		  }
		});
		return true;
}



</script>
