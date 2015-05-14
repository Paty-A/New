<?
// Variables
$title = "Just Salad Intranet";

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#"><?=$title?></a>
          <div class="nav-collapse">
            <ul class="nav">
              <!--
			  <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
			  -->
            </ul>
            <!--<p class="navbar-text pull-right">Logged in as <a href="#">username</a></p>-->
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Central Systems</li>
              	<li><a href="http://mail.google.com/a/justsalad.com">E-Mail</a></li>             
              	<li><a href="http://www.justsaladfranchise.com">Purchase Orders</a></li>
              	<li><a href="http://www.orderjustsalad.com">OrderJustSalad.com</a></li>
        		<li><a href="http://www.justsaladfranchise.com/">JS Franchise</a></li>
              <li class="nav-header">General Report/Forms</li>
                <li><a href="https://docs.google.com/a/justsalad.com/spreadsheet/viewform?formkey=dFl4bFA1VjdTYXp6d1dzdldUb0N0eVE6MQ">JS Signage Inventory</a></li>
                <li><a href="https://justsalad.wufoo.com/forms/timeoff-request-form/">Vacation Request</a></li>
              <li class="nav-header">Human Resources Report/Forms</li>
                <li><a href="http://goo.gl/forms/5Z00cIUbmE">Employee Request Form</a></li>
		<li><a href="http://goo.gl/forms/oDf9OSqu9V">Employee Sharing Form</a></li>
		<li><a href="APPD.pdf">Action Plan Professional Development</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">     
          <!--
		  <div class="hero-unit">
            <h1>Hello, world!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
          </div>
		  -->
		  <div class="row-fluid">
		    <!--
			<div class="span9">
		      <div class="alert alert-info">Welcome to the new Just Salad intranet page.</div>
			</div>  
			-->
		  </div>
          <div class="row-fluid">
            <div class="span4">
              <h2>E-mail</h2>
              <p>Access your Just Salad e-mail account.</p>
              <p><a class="btn btn-primary btn-large" href="http://mail.google.com/a/justsalad.com">Check-Email</a></p>
            </div><!--/span-->
            <div class="span4">
              <h2>Helpdesk</h2>
              <p>Contact JS Helpdesk and open a ticket instantly.</p>
              <p class="btn btn-inverse btn-large" align="center">&ensp;&ensp;
              	<!--If you already have jquery on the page you don't need to insert this script tag-->
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
                <link href="https://d218iqt4mo6adh.cloudfront.net/assets/widget_embed_191.css" media="screen" rel="stylesheet" type="text/css" />
                <!--If you already have fancybox on the page this script tag should be omitted-->
                <script src="//desk-customers.s3.amazonaws.com/shared/widget_embed_libraries_192.js" type="text/javascript"></script>

                <script>
                                
                                // ********************************************************************************
                                // This needs to be placed in the document body where you want the widget to render
                                // ********************************************************************************
                                
                                new DESK.Widget({ 
                                        version: 1, 
                                        site: 'jsit.desk.com', 
                                        port: '80', 
                                        type: 'email', 
                                        displayMode: 0,  //0 for popup, 1 for lightbox
                                        features: {  
                                        },  
                                        fields: { 
                                                ticket: { 
                                                        // desc: &#x27;&#x27;,
                                // labels_new: &#x27;&#x27;,
                                // priority: &#x27;&#x27;,
                                // subject: &#x27;&#x27;
                                                }, 
                                                interaction: { 
                                                        // email: &#x27;&#x27;,
                                // name: &#x27;&#x27;
                                                }, 
                                                email: { 
                                                        //subject: '', 
                                                        //body: '' 
                                                }, 
                                                customer: { 
                                                        // company: &#x27;&#x27;,
                                // desc: &#x27;&#x27;,
                                // first_name: &#x27;&#x27;,
                                // last_name: &#x27;&#x27;,
                                // locale_code: &#x27;&#x27;,
                                // title: &#x27;&#x27;
                                                } 
                                        } 
                                }).render();  
                 </script>
                </td></tr>&ensp;&ensp;</p>
            </div><!--/span-->
            <div class="span4">
              <h2>PO System</h2>
              <p>Place and check your PO Vendor Orders.</p>
              <p><a class="btn btn-primary btn-large" href="http://www.justsaladfranchise.com/home">JS PO System</a></p>
            </div><!--/span-->
          </div><!--/row-->

		  <div class="row-fluid">&nbsp;</div>
  		  <div class="row-fluid">&nbsp;</div>
          
          <div class="row-fluid">
            <div class="span4">
              <h2>OJS</h2>
              <p>Go to OJS Log-in Page for Orders and Check-In</p>
              <p><a class="btn btn-primary btn-large" href="https://www.orderjustsalad.com/account.php">OJS Log In</a></p>
            </div><!--/span-->

            <div class="span4">
              <h2>Seamless</h2>
              <p>Seamless Vendor Login Page.</p>
              <p><a class="btn btn-primary btn-large" href="https://www.seamless.com/vendor/">Seameless</a></p>
            </div><!--/span-->

            <div class="span4">
              <h2>GrubHub</h2>
              <p>GrubHub Vendor Log-in Page.</p>
              <p><a class="btn btn-primary btn-large" href="https://myaccount-labs.grubhub.com/">GrubHubm</a></p>
            </div><!--/span-->
          </div><!--/row-->

		  <div class="row-fluid">&nbsp;</div>          
		  <div class="row-fluid">&nbsp;</div>

          <div class="row-fluid">
             <div class="span4">
              <h2>Stores</h2>
			  <p>From any Cisco phone, you can dial the extension below to reach another store.</p>
              <table cellpadding="3">
			  <tr><td><strong>Call Center</strong></td><td><span class="badge badge-info">10-802</span></td></tr>
			  <tr><td><strong>320 Park</strong></td><td><span class="badge badge-info">11-100</span></td></tr>
			  <tr><td><strong>37th Street</strong></td><td><span class="badge badge-info">12-100
			  <tr><td><strong>Maiden</strong></td><td><span class="badge badge-info">13-100</span></td></tr>
			  <tr><td><strong>30 Rock</strong></td><td><span class="badge badge-info">14-100</span></td></tr>
			  <tr><td><strong>600 Third</strong></td><td><span class="badge badge-info">15-100</span></td></tr>
			  <tr><td><strong>6th Ave</strong></td><td><span class="badge badge-info">16-100</span></td></tr>
			  <tr><td><strong>WWP</strong></td><td><span class="badge badge-info">17-100</span></td></tr>
			  <tr><td><strong>663 Lex</strong></td><td><span class="badge badge-info">18-100</span></td></tr>
			  <tr><td><strong>8th Street</strong></td><td><span class="badge badge-info">19-100</span></td></tr>
			  <tr><td><strong>83rd Street</strong></td><td><span class="badge badge-info">21-100</span></td></tr>
			  <tr><td><strong>1306 1st Ave</strong></td><td><span class="badge badge-info">22-100</span></td></tr>
			  <tr><td><strong>325 Hudson </strong></td><td><span class="badge badge-info">23-100</span></td></tr>
			  <tr><td><strong>90 Broad St. </strong></td><td><span class="badge badge-info">24-100</span></td></tr>
			  <tr><td><strong>2056 Broadway </strong></td><td><span class="badge badge-info">25-100</span></td></tr>
			  <tr><td><strong>140 8th Avenue </strong></td><td><span class="badge badge-info">26-100</span></td></tr>
			  <tr><td><strong>Herald Sq. (Macy's) </strong></td><td><span class="badge badge-info">27-100</span></td></tr>
			  </table>
            </div><!--/span-->
			<div class="span4">
              <h2>Support</h2>
			  <table cellpadding="3">
			  <tr><td><strong>JS Call Center</strong></td><td><span class="badge badge-info">212-244-1111 ext 1</span></td></tr>
			  <tr><td><strong>Seamless Support</strong></td><td><span class="badge badge-info">800-905-9322 ext 2</span></td></tr>
			  <tr><td><strong>POS Support</strong></td><td><span class="badge badge-info">800-454-0592 ext 3</span></td></tr>
			  <tr><td><strong>Help Desk Extension</strong></td><td><span class="badge badge-info">10-322</span></td></tr>
			  </table>
                  
                    
            </div><!--/span-->
           
            <div class="span4">
              <h2>Social</h2>
              <p>Keep up on the latest Just Salad News</p>
              <table cellpadding="3">
			  <tr><td><strong>Blog</strong></td><td><a href="http://www.justsalad.com/blog" class="badge badge-info">justsalad.com/blog</span></td></tr>

			  <tr><td><strong>Facebook</strong></td><td><a href="http://www.facebook.com/justsalad" class="badge badge-info">facebook.com/justsalad</span></td></tr>
			  <tr><td><strong>Twitter</strong></td><td><a href="http://www.twitter.com/justsalad" class="badge badge-info">twitter.com/justsalad</span></td></tr>
</span></td></tr>
			  </table>
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Just Salad 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
</html>
