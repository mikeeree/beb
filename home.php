<?php
session_start();

if (!isset($_SESSION['role'])) {
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blue Eagle Bookings</title>
  <link rel="stylesheet" href="./css/home.css" />
  <!-- icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <script src="./js/main.js" defer></script>
</head>

<body>
  <header>
    <div class="logo">
      <img src="./assets/images/Ateneo_de_Manila_University_seal.svg" alt="logo" class="school-logo" />
      <div>
        <h1>BLUE EAGLE</h1>
        <h1 class="gold-text">BOOKINGS</h1>
      </div>
    </div>
    <div class="profile">
      <div class="dropdown">
        <span><i class="fa-solid fa-bars burger"></i></span>
        <div class="dropdown-content">
          <!-- Dropdown options -->
          <a href="mybookings.php">My Bookings</a>
          <form action="./logout.php" method="post">
            <button type="submit">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <main>
    <section class="provision">
      <h1>WELCOME,<br><span class="gold-text">ATENEAN!</span>
      </h1>
      <p>To book a venue, select a room that you want to reserve then click ‘Book’. Afterward, a pop-up would appear that would enable you to choose a date in the calendar. Do take note of its colors: green entails that it is available on that date, red indicates that the venue has been booked for that date, and yellow indicates that someone sent the request letter but has not been approved yet by the administrator; thus, it has a chance that it can turn green if it was rejected, and red if it was approved. You can only send your request form to the green-colored date. Once the letter has been sent, then kindly check the “My Bookings” page for any update regarding your booking.</p>
    </section>
    <section class="rooms">
      <div class="room-item bg-room-1">
        <h2>Leong Hall</h2>
        <p class="room-detail">
          One of the largest auditoriums in Ateneo de Manila, fully equipped
          with aircon, speakers, microphones, computer, screen, and clicker.
          This room is mostly used for huge events of the organizations,
          seminars, and lectures. Moreover, the location is also convenient
          since the pick-up and drop-off station is just outside the
          auditorium. Ultimately, Leong Hall is perfect for events like large
          conferences, and major organizational events that would invite
          people from outside Ateneo to join.
        </p>
        <p>Capacity: 476</p>
        <button class="btn" data-id="1">
          BOOK
        </button>
      </div>
      <div class="room-item bg-room-2">
        <h2>Escaler Hall</h2>
        <p class="room-detail">
          Escaler Hall is a lecture hall situated on the first floor of the
          SEC A building. The hall is equipped with LCD screens, microphones,
          computers, and clickers. It is fully air-conditioned and features
          chairs with foldable tables. Escaler Hall is an ideal venue for
          general assemblies, talks, or lectures, as it can accommodate a
          large number of people and provides tables for attendees to take
          notes.
        </p>
        <p>Capacity: 250</p>
        <button class="btn" data-id="2">
          BOOK
        </button>
      </div>
      <div class="room-item bg-room-3">
        <h2>MVP Roof Deck</h2>
        <p class="room-detail">
          Located at the top floor of the MVP Building, this
          venue, although it lacks air conditioning, offers a nice overlooking
          view of Ateneo, a large space perfect for team building. It does not
          come with projectors, microphones, and screens, but it can be made
          available upon request. MVP Roofdeck is mostly used for
          organizational events that would require team building, games, and
          other physical activities for a large group of people.
        </p>
        <p>Capacity: 400</p>
        <button class="btn" data-id="3">
          BOOK
        </button>
      </div>
      <div class="room-item bg-room-4">
        <h2>Rizal Mini Theater</h2>
        <p class="room-detail">
          Rizal Mini Theatre, also known as Faber Hall, is a
          theater located near the entrance of the Xavier Building. The
          theater is fully air-conditioned and equipped with a spacious stage,
          making it an ideal venue for performances and plays. Additionally,
          its capacity to accommodate a substantial number of people is
          perfect for hosting various types of performances.
        </p>
        <p>Capacity: 200</p>
        <button class="btn" data-id="4">
          BOOK
        </button>
      </div>
      <div class="room-item bg-room-5">
        <h2>Ching Tan Room</h2>
        <p class="room-detail">
          Located on the first floor of the JGSOM Building, Ching
          Tan is an airconditioned room equipped with LCD, Screen, and
          Microphone perfect for big classes, conferences, and lectures.
          Moreover, the room has different levels of long tables that are also
          equipped with sockets. Usually, this room is used for case studies,
          and general assemblies of organizations.
        </p>
        <p>Capacity: 98</p>
        <button class="btn" data-id="5">
          BOOK
        </button>
      </div>
    </section>
    <div id="myModal" class="modal" onclick="closeModal(event)">
      <div class="modal-content" onclick="event.stopPropagation()">
        <div id="calendar" class="calendar"></div>
        <form id="booking-form">
          <input type="hidden" id="dateSelected" required />
          <div class="file-upload">
            <label for="file_src" class="file-upload-label">Upload The Request Letter</label>
            <input type="file" id="file_src" accept="application/pdf" class="file-upload-input" required>
          </div>
          <button type="submit" class="btn-calendar">
            BOOK
          </button>
        </form>
      </div>
    </div>
  </main>
</body>

</html>