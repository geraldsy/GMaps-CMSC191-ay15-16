<!DOCTYPE html>
<html>
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gmaps";

        // Create connection
        $conn = new mysqli($servername, $username,$password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM markers";
        $result = $conn->query($sql);
        $rows=array();
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //echo "Name " . $row["name"] . " ID: " . $row["id"]. " - lat: " . $row["lat"]. " lng " . $row["lng"] . " type " . $row["type"] . "<br>";
                $rows[]=array($row["lat"],$row["lng"],$row["type"]);
            }   
            //echo $rows[0][0] . $rows[0][1] . $rows[0][2];
        } else {
            echo "0 results";
        }

        $conn->close();
    ?>

    <head>
        <script src="http://maps.googleapis.com/maps/api/js?key=API_KEY"></script>
        <script>
        	var pinColor = "cccc00";
            var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));
            var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
                new google.maps.Size(40, 37),
                new google.maps.Point(0, 0),
                new google.maps.Point(12, 35));
            var pinColor1 = "99cc00";
            var pinImage1 = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor1,
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));
            var pinColor2 = "00ff00";
            var pinImage2 = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor2,
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));
            var pinColor3 = "00ffff";
            var pinImage3 = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor3,
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));
            var pinColor4 = "3366cc";
            var pinImage4 = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor4,
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));
            var pinColor5 = "000099";
            var pinImage5 = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor5,
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));
            var pinColor6 = "333399";
            var pinImage6 = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor6,
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));
            var pinColor7 = "6600cc";
            var pinImage7 = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor7,
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));
            var pinColor8 = "660066";
            var pinImage8 = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor8,
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));

            function initialize()
            {
                var center = new google.maps.LatLng(14.167525, 121.243368);//uplb

                var locations = <?php echo json_encode($rows); ?>;
                var i,marker;
                var mapProp = {
                  center:center,
                  zoom:30,
                  mapTypeId:google.maps.MapTypeId.ROADMAP
                };
                var smcenter = new google.maps.LatLng(14.202888,121.155655);
                var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
                var sm = new google.maps.Circle({
                    center:smcenter,
                    radius:250,
                    strokeColor:"#000000",
                    fillColor: "#333399",
                    strokeOpacity: 0.9
                })
                sm.setMap(map);
                var color;
                var mall=[];
                var pathall=[]
                 for (i = 0; i < locations.length; i++) {  
                     
                    var myLatLng = new google.maps.LatLng(locations[i][0],locations[i][1]);
                    if(locations[i][2]== "Restaurant")
                         color = pinImage;
                    else if(locations[i][2]== "Auditorium")
                         color = pinImage1;
                    else if(locations[i][2]== "Mall"){
                        color = pinImage3;
                        mall.push(myLatLng);
                    }
                    else if(locations[i][2]== "Inn")
                        color = pinImage4;
                    else if(locations[i][2]== "Bank")
                        color = pinImage5;
                    else if(locations[i][2]== "Municipal Hall")
                        color = pinImage6;
                    else if(locations[i][2]== "Resort")
                        color = pinImage7;
                    else if(locations[i][2]== "Amusement Park")
                        color = pinImage8;
                    var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                        icon: color,
                    });
                    pathall.push(myLatLng);
                  }
                var flightPath;
                var mall3=[];
                for(i = 0; i < mall.length; i++){
                    for(j = 0; j < mall.length; j++){
                        mall3.push(mall[i]);
                        mall3.push(mall[j]);
                        //document.write(i + "" + j + " ");
                        var flightPath=new google.maps.Polyline({
                          path:mall3,
                          strokeColor:"#00ffff",
                          strokeOpacity:0.5,
                          strokeWeight:10
                          });
                        flightPath.setMap(map);
                        mall3=[];
                     }
                }

                
                var pathpath=new google.maps.Polyline({
                  path:pathall,
                  strokeColor:"#FF0000",
                  strokeOpacity:0.5,
                  strokeWeight:6
                  });

                    pathpath.setMap(map);
                 
                  
                     
            }


        google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>

    <body>
    <script>

    	
    </script>
    <div id="googleMap" style="width:1500px;height:1500px;">
    </div>
</body>
</html>
