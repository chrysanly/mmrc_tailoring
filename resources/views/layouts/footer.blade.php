<footer id="footer">
    <div class="container px-4 py-5 ">

        <div class="d-flex justify-content-around align-items-center">
            <div>
                <h5>Operating Hours ({{ $scheduleTitle }})</h5>
                @foreach ($storeSchedule as $schedule)
                    {{ $schedule }} <br>
                @endforeach

            </div>
            <div>
                <h5>Contact us</h5>
                <p>Subybyc Z.C</p>
                <a href="#">merzsevilla1997@gmail.com</a>
                <p>09123456789</p>
                <a href="#">Facebook Link</a>
            </div>
        </div>

    </div>
</footer>
