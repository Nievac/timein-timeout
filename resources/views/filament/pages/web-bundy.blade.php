<x-filament-panels::page>
    <div class="container flex px-4 mx-auto">
        <div class="w-4/12">
            <h2 class="mb-2">Today is {{ now()->format('F d, Y (l)') }}</h2>
            <div id="MyClockDisplay" class="text-2xl clock min-h-[2rem]"></div>
            <div class="py-3">
                <div class="flex">
                    <div class="mr-1">{{ $this->timeInAction}}</div>
                    <div>{{ $this->timeOutAction }}</div>
                </div>
            </div>
        </div>
        <div class="w-8/12">
            <h2>Time Entry Logs</h2>
            <div class="mt-2">
                {{ $this->table }}
            </div>
        </div>
    </div>

<script>
function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    if(h == 0){
        h = 12;
    }

    if(h > 12){
        h = h - 12;
        session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;

    setTimeout(showTime, 300);

}

showTime();
</script>
</x-filament-panels::page>
