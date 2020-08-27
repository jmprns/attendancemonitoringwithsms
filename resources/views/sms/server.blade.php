<!DOCTYPE html>
<html>
<head>
  <title></title>
    <style>
    body {
        background: white; 
        font-family: Century Gothic;
    }
    section {
        background: black;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        color: white;
        padding: 1em;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
    }
    h1{
    	font-size: 70px;
    }
  </style>
</head>
<body>
  <center>
  	<section>
      <h1><span id="sms_count">0</span></h1>
      <h2>Pending SMS</h2>
      <p>The page will refresh to fetch the SMS in <span id="countdowntimer">10 </span> seconds.</p>
  </section>
  </center>


  <script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">  
	$(document).ready(function () {
				
                $.ajax({
                    url: "/sms/count",
                    method: "GET",
                    dataType: 'json',
                    success:function(Result){

                        var count = Result.count;
                        document.getElementById('sms_count').textContent = count;
                        
                        if(count !== 0){

                            let loops = Result.lists.forEach(function(value, key){
                                send(value.number, value.text);
                                console.log(value.number);
                            });

                            $(document).ajaxStop(function() {
                                location.reload();
                            });


                        }

                        if(count == 0){
                            setTimeout(function() {
                                location.reload();
                            }, 10000);
                        }
                        document.getElementById('sms_count').textContent = count;

                    }
                });

               

                function send(number, message){
                    $.ajax({
                    url: `http://{{$server}}?number=${number}&text=${message}`,
                    method: "GET",
                    dataType: 'json',
                    success:function(Result){
                    }
                    });
                }
				
			});


</script>
  
</body>
</html>