<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>MySystem</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">MySystem</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/goods">Goods</a></li>
            <li class="active"><a href="#">Agents</a></li>
            <li><a href="/address">Address</a></li
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <h1>Agents in the system</h1>
        <p class="lead">Available agents in the system</p>
      </div>

      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <table class="table table-condensed">
              <thead>
                <tr>
                  <th>#</th> <th>First name</th> <th>Last name</th> <th>Operations</th>
                </tr>
              </thead>
              <tbody>
                <?php $counter = 1; ?>
                <?php foreach ($agents as $agent) { ?>
                <tr>
                  <th scope="row"><?php echo $counter++; ?></th> <td><?php echo $agent->fname; ?></td> <td><?php echo $agent->lname; ?></td>
                  <td>
                    <a href="/agents/edit/<?php echo $agent->id; ?>" class="btn btn-default btn-xs active go" role="button">
                      <span class="glyphicon glyphicon-pencil" aria-hidden="true"> Edit
                    </a>
                    <a href="/agents/remove/<?php echo $agent->id; ?>" class="btn btn-default btn-xs active" role="button">
                      <span class="glyphicon glyphicon-trash" aria-hidden="true"> Remove
                    </a>
                  </td>
                </tr>
                <?php } ?>


              </tbody>
          </table>
          <hr>
        </div>
      </div>

      <div class="row">
        <div class="col-md-1 col-md-offset-5">
            <a href="#" class="btn btn-default btn-sm active" role="button" data-toggle="modal" data-target="#myModal">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"> Add
            </a>
        </div>
      </div>

    </div><!-- /.container -->

    <!-- Modal Window  agents start-->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Adding the agent</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="POST" id="agents-form" action="/agents/add">
              <div class="form-group">
                <label for="inputAgentFname">Agent first name</label>
                <input type="text" class="form-control" name="inputAgentFname" id="inputAgentFname" placeholder="First name">
              </div>
              <div class="form-group">
                <label for="inputAgentLname">Agent last name</label>
                <input type="text" class="form-control" name="inputAgentLname" id="inputAgentLname" placeholder="Last name">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-default">Save</button>
            </form>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>

        </div>

      </div>
    </div>
    <!-- Modal window agents end-->

    <!-- Modal window agent edit start -->
      <div id="modal_form_ed">
            <span id="modal_close">X</span>
            <h4>Update agent information</h3>
            <form role="form" method="POST" id="agent-form-edit" action="/agents/edit/1">
              <div class="form-group">
                <label for="newFname">New first name</label>
                <input type="text" class="form-control" name="newFname" id="newFname" placeholder="New first name">
              </div>
              <div class="form-group">
                <label for="newLname">New last name</label>
                <input type="text" class="form-control" name="newLname" id="newLname" placeholder="New last name">
              </div>
            <button type="submit" class="btn btn-default pull-right">Update</button>
            </form>
      </div>
      <div id="overlay"></div>
      <!-- Modal window product edit end -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <!-- Edit modal window script -->
    <script>
        $(document).ready(function() {


        	$('a.go').click( function(event){
        		event.preventDefault();
            var formAction = $(this).attr('href');
            $("#agent-form-edit").attr("action", formAction);


        		$('#overlay').fadeIn(400, // снaчaлa плaвнo пoкaзывaем темную пoдлoжку
        		 	function(){ // пoсле выпoлнения предъидущей aнимaции
        				$('#modal_form_ed')
        					.css('display', 'block') // убирaем у мoдaльнoгo oкнa display: none;
        					.animate({opacity: 1, top: '50%'}, 200); // плaвнo прибaвляем прoзрaчнoсть oднoвременнo сo съезжaнием вниз
        		});
        	});
        	/* Зaкрытие мoдaльнoгo oкнa, тут делaем тo же сaмoе нo в oбрaтнoм пoрядке */
        	$('#modal_close, #overlay').click( function(){ // лoвим клик пo крестику или пoдлoжке
        		$('#modal_form_ed')
        			.animate({opacity: 0, top: '45%'}, 200,  // плaвнo меняем прoзрaчнoсть нa 0 и oднoвременнo двигaем oкнo вверх
        				function(){ // пoсле aнимaции
        					$(this).css('display', 'none'); // делaем ему display: none;
        					$('#overlay').fadeOut(400); // скрывaем пoдлoжку
        				}
        			);
        	});
        });
    </script>
  </body>
</html>
