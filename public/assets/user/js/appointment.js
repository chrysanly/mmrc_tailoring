document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const limit = document.getElementById('max_limit').innerText;

    const appointmentCounts = {}; // Object to keep track of appointment counts per day

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: function (fetchInfo, successCallback, failureCallback) {
            fetch('appointment/fetch-appointments')
                .then(response => response.json())
                .then(data => {
                    const events = data.appointments.map(appointment => ({
                        start: appointment.date,
                        title: `Appointments (${appointment.count})`,
                        allDay: true,
                        extendedProps: {
                            count: appointment.count,
                            schedules: appointment.schedules
                        }
                    }));
                    successCallback(events);
                })
                .catch(error => {
                    console.error("Error fetching appointments:", error);
                    failureCallback(error);
                });
        },
        eventDidMount: function (info) {
            const formattedDate = info.event.startStr;

            // Update appointment count for the day
            if (!appointmentCounts[formattedDate]) {
                appointmentCounts[formattedDate] = 0;
            }
            appointmentCounts[formattedDate] += info.event.extendedProps.count;

            const dayCells = document.querySelectorAll(`.fc-daygrid-day[data-date="${formattedDate}"]`);
            if (!dayCells.length) {
                console.warn("No matching day cells found for:", formattedDate);
                return;
            }

            dayCells.forEach(dayCell => {
                let dayTop = dayCell.querySelector('.fc-daygrid-day-top');
                let dayFrame = dayCell.querySelector('.fc-daygrid-day-frame');

                if (!dayTop || !dayFrame) {
                    console.warn("No .fc-daygrid-day-top or .fc-daygrid-day-frame found inside:", dayCell);
                    return;
                }

                // Remove existing badge to prevent duplicates
                let existingBadge = dayTop.querySelector('.appointment-count-badge');
                if (existingBadge) existingBadge.remove();

                // Append badge if count exists and is greater than 0
                if (info.event.extendedProps.count > 0) {
                    let countBadge = document.createElement('span');
                    countBadge.className = 'badge appointment-count-badge';
                    countBadge.innerText = info.event.extendedProps.count;
                    countBadge.style.position = 'absolute';
                    countBadge.style.left = '2px';
                    countBadge.style.fontSize = '12px';
                    countBadge.style.padding = '3px 6px';
                    countBadge.style.borderRadius = '50%';

                    dayTop.appendChild(countBadge);
                }

                // Remove existing schedule list to prevent duplicates
                let existingList = dayFrame.querySelector('.schedule-list');
                if (existingList) existingList.remove();

                if (info.event.extendedProps.schedules.length > 0) {
                    let scheduleList = document.createElement('ul');
                    scheduleList.className = 'schedule-list';
                    scheduleList.style.margin = '0';
                    scheduleList.style.fontSize = 'small';
                    scheduleList.style.listStyleType = 'none';
                    scheduleList.style.position = 'absolute';
                    scheduleList.style.width = '100%';
                    scheduleList.style.top = '25px';
                    scheduleList.style.display = 'block';
                    scheduleList.style.backgroundColor = '#fff';
                    scheduleList.style.border = '1px solid #ddd';
                    scheduleList.style.borderRadius = '5px';
                    scheduleList.style.padding = '5px';
                    scheduleList.style.marginTop = '5px';
                    scheduleList.style.minHeight = 'auto';
                    scheduleList.style.textAlign = "center";
                    scheduleList.style.maxHeight = '250px';
                    scheduleList.style.overflowY = 'auto';

                    info.event.extendedProps.schedules.forEach(schedule => {
                        let listItem = document.createElement('li');
                        listItem.innerText = `${schedule.time_from} - ${schedule.time_to}`;
                        scheduleList.appendChild(listItem);
                    });

                    dayFrame.appendChild(scheduleList);
                }

                
                if (appointmentCounts[formattedDate] >= limit) {
                    dayCell.classList.add('max-limit-day');
                }
            });
        },
        dateClick: function (info) {
            const today = new Date().setHours(0, 0, 0, 0);
            const clickedDate = new Date(info.dateStr).setHours(0, 0, 0, 0);
            const dayCell = document.querySelector(`.fc-daygrid-day[data-date="${info.dateStr}"]`);

            if (clickedDate >= today && dayCell && !dayCell.classList.contains('max-limit-day')) {
                const selectedDate = info.dateStr;
                const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                document.getElementById('modalDate').innerText = selectedDate;
                document.getElementById('selectedDate').value = selectedDate;
                modal.show();
            }
        },
        datesSet: function () {
            const today = new Date().setHours(0, 0, 0, 0);
            document.querySelectorAll('.fc-daygrid-day').forEach(dayCell => {
                const date = new Date(dayCell.dataset.date).setHours(0, 0, 0, 0);
                if (date < today) {
                    dayCell.classList.add('disabled-day');
                }
            });
        }
    });

    calendar.render();

    const modal = new bootstrap.Modal(document.getElementById("appointmentGuideModal"));
    modal.show();
});
