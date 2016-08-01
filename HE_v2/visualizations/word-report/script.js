
        var project;


			$(document).ready(function(){

            project = getUrlParameter("w");

            if (typeof project == 'undefined' || project==""){
              project = "bologna";
            }

            $("#w").val(project);

			});

      function submitForm(){
        var v = $("#iinput").val();
        v = v.trim();
        if(v.length>2){
          $("#extractorform").submit();  
        } else {
          alert("try harder! a bit more of inspiration!");
        }
        
      }


      function getContrastYIQ(hexcolor){
          var r = parseInt(hexcolor.substr(1,2),16);
          var g = parseInt(hexcolor.substr(3,2),16);
          var b = parseInt(hexcolor.substr(4,2),16);
          var yiq = ((r*299)+(g*587)+(b*114))/1000;
          return (yiq >= 128) ? 'black' : 'white';
      }


      function getRandomArbitrary(min, max) {
          return Math.random() * (max - min) + min;
      }



      function getUrlParameter(sParam)
      {
          var sPageURL = window.location.search.substring(1);
          var sURLVariables = sPageURL.split('&');
          for (var i = 0; i < sURLVariables.length; i++) 
          {
              var sParameterName = sURLVariables[i].split('=');
              if (sParameterName[0] == sParam) 
              {
                  return sParameterName[1];
              }
          }
      }