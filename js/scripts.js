// SIDEBAR TOGGLE

var sidebarOpen = false;
var sidebar = document.getElementById("sidebar");

function openSidebar() {
    if(!sidebarOpen) {
        sidebar.classList.add("sidebar-responsive");
        sidebarOpen = true;
    }
}

function closeSidebar() {
    if(sidebarOpen) {
        sidebar.classList.remove("sidebar-responsive");
        sidebarOpen = false;
    }
}






// -------------- DYNAMIC CALENDAR -------------
const daysTag = document.querySelector(".days"),
currentDate = document.querySelector(".current-date"),
prevNextIcon = document.querySelectorAll(".icons span");

// getting new date, current year and month
let date = new Date(),
currYear = date.getFullYear(),
currMonth = date.getMonth();

// storing full name of all months in array
const months = ["January", "February", "March", "April", "May", "June", "July",
              "August", "September", "October", "November", "December"];

document.addEventListener('DOMContentLoaded', function () {
    const occupiedDates = ["2024-01-30", "2024-01-11", "2024-02-01"];
    const occupiedDates2 = ["2024-01-14", "2024-01-13", "2024-01-01"];

    const renderCalendar = () => {
      let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(); // getting first day of the month
      let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(); // getting last date of the month
      let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(); // getting last day of the month
      let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of the previous month
      let liTag = "";
  
      // Create li for the previous month's last days
      for (let i = firstDayofMonth; i > 0; i--) {
          liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
      }
  
      // Create li for all days of the current month
      for (let i = 1; i <= lastDateofMonth; i++) {
          let isToday = i === date.getDate() && currMonth === date.getMonth() && currYear === date.getFullYear() ? "active" : "";
          let isOccupied = occupiedDates.includes(`${currYear}-${padZero(currMonth + 1)}-${padZero(i)}`) ? "occupied1" : "";
          let isOccupied2 = occupiedDates2.includes(`${currYear}-${padZero(currMonth + 1)}-${padZero(i)}`) ? "occupied2" : "";
          
        if (isOccupied=="occupied1"){
          liTag += `
              <li class="${isToday} ${isOccupied}">
                  <span style="
                      width: 2em;
                      height: 2em;
                      line-height: 2em;
                      text-align: center;
                      border-radius: 50%;
                      display: inline-block;
                      background-color: ${isOccupied ? 'black' : 'transparent'};
                      color: ${isOccupied ? 'white' : 'black'};
                  ">
                      ${i}
                  </span>
              </li>`;
        }    
        console.log(isOccupied2);
              liTag+= `
              <li class="${isToday} ${isOccupied2}">
                  <span style="
                      width: 2em;
                      height: 2em;
                      line-height: 2em;
                      text-align: center;
                      border-radius: 50%;
                      display: inline-block;
                      background-color: ${isOccupied2 ? 'red' : 'transparent'};
                      color: ${isOccupied2 ? 'white' : 'black'};
                  ">
                      ${i}
                  </span>
              </li>`;    
      }
  
      // Create li for next month's first days
      for (let i = lastDayofMonth; i < 6; i++) {
          liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
         
      }
  
      currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current month and year as currentDate text
      daysTag.innerHTML = liTag;
      
  };
  
  renderCalendar();

  prevNextIcon.forEach(icon => { // getting prev and next icons
    icon.addEventListener("click", () => { // adding click event on both icons
        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if(currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
            // creating a new date of current year & month and pass it as date value
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear(); // updating current year with new date year
            currMonth = date.getMonth(); // updating current month with new date month
        } else {
            date = new Date(); // pass the current date as date value
        }
        renderCalendar(); // calling renderCalendar function
    });
});


    renderCalendar();
    
    function padZero(num) {
        return num < 10 ? `0${num}` : num;
    }
});





// -------------- CHARTS ---------------

// BAR CHART

var barChartOptions = {
    series: [{
    data: [130, 70, 55, 15]
  }],
    chart: {
    type: 'bar',
    height: 350,
    toolbar: {
        show: false
    },
  },
  colors: [
    "#246dec",
    "#cc3c43",
    "#367952",
    "#f5b74f",
    "#4f35a1"

  ],
  plotOptions: {
    bar: {
      distributed: true,
      borderRadius: 4,
      horizontal: false,
      columnWidth: '40%',
    }
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false
  },
  xaxis: {
    categories: ["4th Year College", "3rd Year College", "2nd Year College", "1st Year College"],
  },
  yaxis: {
    title: {
        text: "Appointment of Students"
    }
  },
  };

  var barChart = new ApexCharts(document.querySelector("#bar-chart"), barChartOptions);
  barChart.render();
