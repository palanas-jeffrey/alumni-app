@php
    $wrapStyle = 'display:none;';

    if ($chart_type == 'vertical-bar' && $isGraphable) {
        $wrapStyle = 'width: 100%;';
    }
    else if ($isGraphable)
    {
        $wrapStyle = 'width: 48%;';
    }
@endphp

<div style="{{ $wrapStyle }}">
    @if($isGraphable)
        <!-- this colors are based from shared.others.colors -->
        @php
            $colorsInHalfOpacity = [
                    'rgba(69, 173, 252, 0.8)', 'rgba(89, 237, 187, 0.8)', 'rgba(254, 203, 104, 0.8)', 'rgba(255, 129, 148, 0.8)', 'rgba(143, 121, 216, 0.8)',
                    'rgba(46, 196, 182, 0.8)', 'rgba(255, 191, 105, 0.8)', 'rgba(255, 107, 107, 0.8)', 'rgba(106, 76, 147, 0.8)', 'rgba(61, 90, 128, 0.8)',
                    'rgba(152, 193, 217, 0.8)', 'rgba(224, 251, 252, 0.8)', 'rgba(238, 108, 77, 0.8)', 'rgba(41, 50, 65, 0.8)', 'rgba(244, 162, 97, 0.8)',
                    'rgba(231, 111, 81, 0.8)', 'rgba(168, 218, 220, 0.8)', 'rgba(69, 123, 157, 0.8)', 'rgba(29, 53, 87, 0.8)', 'rgba(255, 175, 204, 0.8)',
                    'rgba(205, 180, 219, 0.8)', 'rgba(255, 200, 221, 0.8)', 'rgba(189, 224, 254, 0.8)', 'rgba(162, 210, 255, 0.8)', 'rgba(212, 165, 165, 0.8)',
                    'rgba(132, 165, 157, 0.8)', 'rgba(242, 132, 130, 0.8)', 'rgba(246, 189, 96, 0.8)', 'rgba(247, 237, 226, 0.8)', 'rgba(157, 78, 221, 0.8)'
                ];
        @endphp
    
        <div class="card graph-per-program-container mb-4 rounded-4 shadow">
            <div class="pb-6 pt-6">
                <div class="mb-1">
                    <h3 class="font-medium pl-6 poppins-semibold pr-6 text-lg">{{$field->field_label}}</h3>
                </div>
                <div class="pl-6 pr-6">
                    @if ($isGraphable)
                        <div class="graph-box">
                            @livewire('graph-generic', [
                                'chart_id' => $chart_id,
                                'choices' => $choices,
                                'chart_type' => $chart_type
                            ])
                        </div>
                    @else
                        <div>
                            <p>Unable to display data in graph. The data format is not supported.</p>
                        </div>
                    @endif
                </div>
                <div class="flex flex-wrap line-height-normal mb-2 mt-3 pl-6 poppins-semibold pr-6">
                    @if(count($choiceStats) > 0)
                        @foreach($choiceStats as $choiceStat)
                            <div class="bg-dust-gray p-1 rounded-3 mr-2" 
                                style="background-color: {{ $colorsInHalfOpacity[$loop->index] }}">
                                <span>{{$choiceStat->choice}}: </span>
                                <span>{{$choiceStat->count}}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="pl-6 pr-6">
                    @if($total_responses)
                        <span class="poppins-semibold">Total: {{ $total_responses }} </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
