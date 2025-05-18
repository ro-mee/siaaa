
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="format.css">
    <link rel="Stylesheet" href="css/all.min.css">
  <link rel="Stylesheet" href="css/fontawesome.min.css">
      <style>
        
    .Adashboard {
      display: flex;
      gap: 20px;
      align-items: center;88
    }

    .card {
      width: 280px;
      height: 120px; 
      border-radius: 20px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 25px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      flex: 1;
      margin: 20px 30px
    }

    .orange {
      background: linear-gradient(135deg, #fcae67, #f57c00);
    }

    .purple {
      background: linear-gradient(135deg, #8b8df8, #6a74f7);
    }
.blue {
  background: linear-gradient(135deg, #4dc4f5, #199fe3);
}
.teal {
  background: linear-gradient(135deg, #5eead4, #2dd4bf);
}
    .card-content {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .card-content h2 {
      margin: 0;
      font-size: 32px;
    }

    .card-content p {
      margin: 0;
      font-size: 16px;
      opacity: 0.9;
    }

    .card-icon {
      background: white;
      border-radius: 50%;
      width: 55px;
      height: 55px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .card-icon img {
      width: 30px;
      height: 30px;
    }
    

        
    </style>
</head>
<body>
  <div class="sidebar">
    <img src="bcp logo.png" alt="School Logo" class="logo" />
    <div class="profile-circle"><span id="student-initials"></span></div>
    <div class="profile-info">
      <strong><span id="student-name"></span></strong>
      <p><span id="student-id"></span>@bcp.edu.ph</p>
    </div>

    <h4>Admin Dashboard</h4>
    <div class="nav-item active">
      <a href="#"><span><i class="fa-solid fa-house"></i></span> Dashboard</a>
    </div>
    <div class="nav-item">
      <a href="try.php"><span><i class="fa-regular fa-user"></i></span> Students</a>
    </div>
    <div class="nav-item">
      <a href="#"><span><i class="fa-solid fa-chalkboard"></i></span> Classes</a>
    </div>
    <div class="nav-item">
      <a href="#"><span><i class="fa-solid fa-person-chalkboard"></i></span> Teachers</a>
    </div>
        <div class="nav-item">
      <a href="#"><span><i class="fa-solid fa-book"></i></span> Subject</a>
    </div>
        <div class="nav-item">
      <a href="#"><span><i class="fa-regular fa-address-card"></i></span> Account Access</a>
    </div>
        <div class="nav-item">
      <a href="login.php"> <i class="fa-solid fa-right-from-bracket"></i></span> Logout</a>
    </div>
  </div>
     <script>
    // Select all nav-item elements
    const navItems = document.querySelectorAll('.nav-item');

    navItems.forEach(item => {
      item.addEventListener('click', () => {
        // Remove 'active' from all
        navItems.forEach(i => i.classList.remove('active'));
        // Add 'active' to the clicked one
        item.classList.add('active');
      });
    });
  </script>

 <div class="main-content">
    <div class="top-bar">
      <div class="menu">
        <h1 class="page-title">Dashboard</h1>
        <span class="breadcrumb">School Management</span>
  <div class="Adashboard">
    <!-- Student Card -->
    <div class="card orange">
      <div class="card-content">
        <h2>1256</h2>
        <p>Students</p>
      </div>
      <div class="card-icon">
        <img src="gradcap.png" alt="Student Icon">
      </div>
    </div>

    <!-- Teacher Card -->
    <div class="card purple">
      <div class="card-content">
        <h2>102</h2>
        <p>Teachers</p>
      </div>
      <div class="card-icon">
        <img src="teacher.png" alt="Teacher Icon">
      </div>
    </div>
    
  </div>
  <div class="Adashboard">
          <div class="card blue">
      <div class="card-content">
        <h2>102</h2>
        <p>Classes</p>
      </div>
      <div class="card-icon">
        <img src="classes.png" alt="Teacher Icon">
      </div>
    </div>
              <div class="card teal ">
      <div class="card-content">
        <h2>102</h2>
        <p>Subject</p>
      </div>
      <div class="card-icon">
        <img src="books.png" alt="Teacher Icon">
      </div>
    </div>
  </div>
     

  </div>
  </div>


</body>
</html>
