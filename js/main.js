// Function to open the modal
function openModal() {
  const modal = document.getElementById("myModal");
  modal.style.display = "block";
}

// Function to close the modal
function closeModal() {
  const modal = document.getElementById("myModal");
  modal.style.display = "none";
  dateSelected.value = "";
  file_src.value = "";
}

// Function to create the calendar
function createCalendar(targetId, onSelect, bookingDates) {
  const calendar = document.getElementById(targetId);
  const today = new Date();
  let year = today.getFullYear();
  let month = today.getMonth();
  let selectedDate = null;

  // Function to get the number of days in a month
  function getDaysInMonth(year, month) {
    return new Date(year, month + 1, 0).getDate();
  }

  // Function to create the calendar header
  function createCalendarHeader() {
    const header = document.createElement("div");
    header.classList.add("calendar-header");

    const prevMonthButton = document.createElement("button");
    prevMonthButton.innerText = "<";
    prevMonthButton.addEventListener("click", showPreviousMonth);
    header.appendChild(prevMonthButton);

    const monthName = document.createElement("span");
    monthName.innerText = new Date(year, month).toLocaleString("default", {
      month: "long",
      year: "numeric",
    });
    header.appendChild(monthName);

    const nextMonthButton = document.createElement("button");
    nextMonthButton.innerText = ">";
    nextMonthButton.addEventListener("click", showNextMonth);
    header.appendChild(nextMonthButton);

    return header;
  }

  // Function to create the calendar days
  function createCalendarDays() {
    const days = document.createElement("div");
    days.classList.add("calendar-days");

    const daysOfWeek = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];

    for (let i = 0; i < daysOfWeek.length; i++) {
      const day = document.createElement("div");
      day.classList.add("calendar-day");
      day.innerText = daysOfWeek[i];
      days.appendChild(day);
    }

    const firstDay = new Date(year, month, 1).getDay();
    const totalDays = getDaysInMonth(year, month);

    for (let i = 0; i < firstDay; i++) {
      const emptyDay = document.createElement("div");
      emptyDay.classList.add("calendar-day");
      days.appendChild(emptyDay);
    }

    for (let i = 1; i <= totalDays; i++) {
      const day = document.createElement("div");
      day.classList.add("calendar-day");
      day.classList.add("available");
      day.innerText = i;

      // Check if the date is in the bookingDates array
      const dateStr = getDateString(year, month, i);

      const bookingDate = bookingDates.find((bd) => bd.date === dateStr);

      // logic for status
      if (bookingDate) {
        // Apply different styles based on the status
        if (bookingDate.status === "pending") {
          day.classList.add("pending");
          day.classList.remove("available");
        } else if (bookingDate.status === "booked") {
          day.classList.add("booked");
          day.classList.remove("available");
        }
      }

      day.addEventListener("click", () => {
        if (selectedDate) {
          selectedDate.classList.remove("selected");
        }

        if (checkDayAvailability(bookingDate)) {
          day.classList.add("selected");
          selectedDate = day;
        }

        onSelect(
          getDateString(year, month, i),
          checkDayAvailability(bookingDate)
        );
      });
      days.appendChild(day);
    }

    return days;
  }

  // function to determine if date is selectable
  function checkDayAvailability(bookingDate) {
    if (bookingDate) {
      if (bookingDate.status === "pending") {
        return false;
      } else if (bookingDate.status === "booked") {
        return false;
      }
    }
    return true;
  }

  // Function to show the previous month
  function showPreviousMonth() {
    if (month === 0) {
      year--;
      month = 11;
    } else {
      month--;
    }
    dateSelected.value = "";

    renderCalendar();
  }

  // Function to show the next month
  function showNextMonth() {
    if (month === 11) {
      year++;
      month = 0;
    } else {
      month++;
    }
    dateSelected.value = "";

    renderCalendar();
  }

  // Function to render the calendar
  function renderCalendar() {
    calendar.innerHTML = "";

    const header = createCalendarHeader();
    const days = createCalendarDays();

    calendar.appendChild(header);
    calendar.appendChild(days);
  }

  // Function to get the date string in 'YYYY-MM-DD' format
  function getDateString(year, month, day) {
    const monthStr = String(month + 1).padStart(2, "0");
    const dayStr = String(day).padStart(2, "0");
    return `${year}-${monthStr}-${dayStr}`;
  }

  // Initialize the calendar
  renderCalendar();
}

const bookingBtn = document.querySelectorAll(".btn");
const dateSelected = document.getElementById("dateSelected");
// set global state for room id
let dataId;

// on click booking listener
bookingBtn.forEach((button) => {
  button.addEventListener("click", async (e) => {
    try {
      const btn = e.target;
      dataId = btn.getAttribute("data-id");

      // fetch booking dates of selected room
      const data = await fetch(`/booking/booking/getBookingDates.php?id=${dataId}`, {
        method: "POST",
      });
      const bookingDates = await data.json();
      openModal();

      createCalendar(
        "calendar",
        (selectedDate, available) => {
          if (available) {
            dateSelected.value = selectedDate;
            console.log(selectedDate);
          } else {
            dateSelected.value = "";
          }
        },
        bookingDates
      );
    } catch (error) {
      console.log(error);
    }
  });
});
// function for submitting the booked date
const bookingForm = document.getElementById("booking-form");
const file_src = document.getElementById("file_src");
bookingForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  try {
    // check if booking date is empty
    if (!dateSelected.value || !dataId) {
      return alert("Please Select a Date");
    }
    const formData = new FormData();
    const file = file_src.files[0];
    formData.append("date", dateSelected.value);
    formData.append("roomid", dataId);
    formData.append("file_src", file);

    // upload files and save data in database
    await fetch("/booking/booking/saveBookingDate.php", {
      method: "POST",
      body: formData,
    });

    alert("Successfully submitted! Check the 'My Bookings' tab for booking updates.");
    closeModal();
  } catch (error) {
    console.log(error);
  }
});
