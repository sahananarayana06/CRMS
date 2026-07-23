<?php
// index.php - Front Page
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crime Record Management System</title>
    <style>
        body{
            margin:0;
            font-family: Arial;
        }

        /* Navigation Bar */
        nav{
            background-color:#2c3e50;
            display: flex;
            align-items: center;
            padding: 10px 30px;
            position: fixed;
            top: 0;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        nav a{
            color:white;
            text-decoration:none;
            margin:2px;
            margin-left: 20px;
            font-size:18px;
            font-weight: bold;
            display: inline;
        }

        nav a:hover{
            color:#2c3e50;
        }

        .nav-bar{
            height: 50px;
            width: 400px;
            align-items: center;
            text-align: center;
            display: flex;
            gap: 30px;
            margin-left:450px;
            border: 2px solid #5a7792 ;
            background-color:#5a7792  ;
            border-radius: 30px;
            box-shadow: 0 2px 2px #5a7792 ;
        }

        /* Header */
        .header{
            margin-top:100px;
            text-align:center;
            background-color:#34495e;
            color:white;
            padding:15px;
        }

        /* Content */
        .content{
            padding:20px;
            text-align:center;
        }

        .body-container{
            background-color:#fff;
            border: 2px solid #fff;
            border-radius: 2em;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            margin-top: 5px;
            box-shadow: o 20px 30px 40px #fff;
        }

        h2{
            color: #2c3e50; 
        }

        ul{
            list-style-position: inside;
            margin-top:10px;
            padding-left: 300px;
            text-align: start;   
        }

        table {
            width: 80%;
            margin: 10px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #374553;
            color: white;
            text-align: center;
        }

        td {
            background-color: #f9fbfd;
        }

        .Station {
            background: #e9edf3;
            margin: 5px 0;
            padding: 8px;
            border-radius: 4px;
        }

        .range {
            font-weight: bold;
            color: #2c3e50;
        }

        /* Footer */
        .footer{
            background-color:#2c3e50;
            color:white;
            text-align:center;
            align-items: center;
            padding:20px;
            width: 100%;
            margin-top:40px;
        }
    </head>
    </style>

<body>

<!-- Navigation Menu -->
 <nav>	
 <img src="images/images.png" alt="Logo" style="width: 90px; height: 90px; flex-shrink: 0; border: 1px solid white; border-radius:50%; "> 
<div>
    <div class="nav-bar">
        <a href="index.php">Home</a>
        <a href="user\signin.php">User</a>
        <a href="police\signin.php">Police</a>
        <a href="admin\signin.php">Admin</a>
    </div>
</div>
</nav>
    <!-- Header -->
    <div class="header">
        <h1>Crime Record Management System – Dakshina Kannada District</h1>
        <p>Manage Crime Records Easily and Securely</p>
    </div>

<div class="body-container">
    <!-- Information -->
    <div class="content">
        <h2 style="margin-top: 5px;">About the Website</h2>

        <p>
        Crime Record Management System is a web based application developed to store
        and manage crime related information digitally. <br> The system helps police
        departments maintain FIR records, criminal details, and investigation reports 
        in an organized way.
        </p>

        <p>
        Users can register complaints online and police officers can manage and update 
        crime records easily through the system.
        </p>

        <!-- E-Court section removed -->
        
        <p style="font-size: large; margin-top: 50px;">The following are the Police Ranges and the Subdivision comprising each Range:</p>
        <table>
            
            <tr>
                <th>Sl.No</th>
                <th>Range</th>
                <th>Police Station Name</th>
            </tr>

            <tr>
                <td>1</td>
                <td class="range">South Subdivision</td>
                <td>
                    <div class="Station">Mangalore South Police Station</div>
                    <div class="Station">Mangalore Rural Police Station</div>
                    <div class="Station">Ullal Police Station</div>
                    <div class="Station">Moodbidri Police Station</div>
                    <div class="Station">Venoor Police Stations</div>
                    <div class="Station">Karkala Police Station</div>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td class="range">Central Subdivision</td>
                <td>
                    <div class="Station">Kankanady Town Police Station</div>
                    <div class="Station">Kadri Police Station</div>
                    <div class="Station">Barke Police Station</div>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td class="range">North Subdivision</td>
                <td>
                    <div class="Station">Mangalore North Police Station</div>
                    <div class="Station">Urwa Police Station</div>
                    <div class="Station">Kavoor Police Station</div>
                    <div class="Station">Surathkal Police Station</div>
                    <div class="Station">Panambur Police Station</div>
                    <div class="Station">Puttur</div>
                </td>
            </tr>

            <tr>
                <td>4</td>
                <td class="range">Rural / District Stations</td>
                <td>
                    <div class="Station">Bantwal Rural Police Station</div>
                    <div class="Station">Dharmasthala Police Station</div>
                    <div class="Station">Mulki Police Station</div>
                    <div class="Station">Belthangady Police Station</div>
                    <div class="Station">Kadaba Police Station</div>
                </td>
            </tr>

            <tr>
                <td>5</td>
                <td class="range">Special Crime Units</td>
                <td>
                    <div class="Station">CEN Crime Police Station</div>
                    <div class="Station">City Crime Branch (CCB) Mangaluru</div>
                </td>
            </tr>

            <tr>
                <td>6</td>
                <td class="range">Traffic Subdivision</td>
                <td>
                    <div class="Station">Mangaluru Traffic Police Stations</div>
                </td>
            </tr>
        </table>
<!-- Footer -->
<div class="footer">
    <h3>Contact Us</h3>
    <p>Email: crmssystem5@gmail.com</p>
    <p>Phone: +91 7760373717</p>
    <p>Address: Karnataka Police Department</p>
</div>

</body>
</html>