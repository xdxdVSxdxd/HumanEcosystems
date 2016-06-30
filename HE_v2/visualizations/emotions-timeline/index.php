<!DOCTYPE html>
<html lang="it" >
<head profile="http://www.w3.org/1999/xhtml/vocab">
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link type="text/css" rel="stylesheet" href="css/bootstrap.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/d3.min.js"></script>
  <script src="js/respond.min.js"></script>
  <script src="js/header.js"></script>
  <style>

  body,html{
    background: #FFFFFF;
    width: 3000px;
  }

  .x text{
    fill: #000000;
  }

  .x line{
    stroke: #000000;
  }

  .x path{
    stroke: #FFFFFF;
    fill: #FFFFFF;
  }



  .y text{
    fill: #FFFFFF;
  }

  .y line{
    stroke: #FFFFFF;
  }

  .y path{
    stroke: #FFFFFF;
    fill: #FFFFFF;
  }


  #emo-timeline-contained{
    width: 100%;
    height: 900px;
    border: 0px;
    margin: 0px;
    padding: 0px;
  }


        #legend{
          height: 311px;
          position: absolute;
          z-index: 900;
          background: rgba(0,0,0,0.3);
          color: #FFFFFF;
          overflow: hidden;
          float: left;
        }
        #legend-head{
          width: 180px;
          padding: 10px;
          overflow: hidden;
          font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
          font-size: 20px;
          line-height: 25px;
          border-bottom: 1px solid #EEEEEE;
        }
        #legend-body{
          width: 180px;
          height: 258px;
          padding: 10px;
          overflow: hidden;
        }

        .legend-item-holder{
          width: 180px;
          height: 15px;
          margin-bottom: 4px;
          overflow: hidden;
          color: #FFFFFF;
          font: 12px Helvetica,sans-serif;
          line-height: 15px;
          clear: auto;
        }
        .legend-color{
          width: 15px;
          height: 15px;
          margin-right: 12px;
          overflow: hidden;
          float: left;
        }
        .legend-lebel{
          width: 153px;
          height: 15px;
          overflow: hidden;
          float: left;
        }



  </style>
<title>General Timeline</title>
</head>
<body>	

              <div id='legend'>
                <div id="legend-head">Legend</div>
                <div id="legend-body"></div>
              </div>


                <div id="emo-timeline-contained">
                </div>
</body>
</html>
