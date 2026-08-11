<div class="bg-dust-gray overflow-hidden rounded-4 shadow-sm">
    <div class="p-4 w-100">
        <section class="w-100">
            <div class="w-100">
                <h2 class="font-medium poppins-semibold text-lg">Alumni registrations</h2>
                <p class="mb-3 text-gray-600 text-sm">Current alumni registration statistics.</p>
                <div class="w-100">
                    <div class="w-100">
                        <div id="alumni-registration-stats"></div>
                    </div>
                </div>
                <div class="txt-28">
                    <span>Total registrations: </span>
                    <span>{{ $alumniCount }}</span>
                </div>
                <div class="mt-32">
                    <x-link-btn href="{{ route('accounts.programs') }}">
                        <span>View accounts</span>
                    </x-link-btn>
                </div>
            </div>
        </section>
    </div>

    <script>
        (function() {
            var labels = [ "BSCS", "BSIS", "BSIT"],
                series = [{{ $bscs }}, {{ $bsis }} , {{ $bsit }}],
                colors = ['#45adfc', '#59edbb','#fecb68', '#ff8194', '#8f79d8'],
                chartContainerId = "#" + "alumni-registration-stats";

            barChartBuilder(chartContainerId, labels, series, colors);
        })();
    </script>
</div>

