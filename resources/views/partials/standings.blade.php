<!-- Table Container -->
<div class="bg-white rounded-xl md:rounded-2xl shadow-sm overflow-hidden border border-gray-50">
    <div class="overflow-x-auto scroolbar-hide">
        <table class="w-full text-left font-sans min-w-full md:min-w-[700px] text-xs md:text-base">
            <thead>
                <tr class="text-gray-400 text-[10px] md:text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                    <th class="py-3 px-1 md:py-5 md:px-6 w-8 md:w-16 text-center">Pos</th>
                    <th class="py-3 px-1 md:py-5 md:px-4">Club</th>
                    <th class="py-3 px-1 md:py-5 md:px-4 text-center" title="Played">Pl</th>
                    <th class="py-3 px-1 md:py-5 md:px-4 text-center" title="Won">W</th>
                    <th class="py-3 px-1 md:py-5 md:px-4 text-center" title="Draw">D</th>
                    <th class="py-3 px-1 md:py-5 md:px-4 text-center" title="Lost">L</th>
                    <th class="py-3 px-1 md:py-5 md:px-4 text-center hidden md:table-cell" title="Goals For">GF</th>
                    <th class="py-3 px-1 md:py-5 md:px-4 text-center hidden md:table-cell" title="Goals Against">GA</th>
                    <th class="py-3 px-1 md:py-5 md:px-4 text-center" title="Goal Difference">Gd</th>
                    <th class="py-3 px-1 md:py-5 md:px-4 text-center" title="Points">Pts</th>
                </tr>
            </thead>
        <tbody class="divide-y divide-gray-50 text-secondary">
            @forelse ($standings as $index => $team)
            <!-- Row -->
            <tr class="hover:bg-gray-50 transition-colors relative">
                <td class="py-3 px-1 md:py-5 md:px-6 text-center text-sm md:text-xl font-black font-outfit relative">
                    @if($index === 0)
                    <!-- Left Green Border for Top Team -->
                    <div class="absolute left-0 top-0 bottom-0 w-1 md:w-1.5 bg-primary rounded-l-2xl"></div>
                    @endif
                    {{ $team['position'] ?? ($index + 1) }}
                </td>
                <td class="py-3 px-1 md:py-5 md:px-4">
                    <div class="flex items-center gap-1.5 md:gap-4">
                        @if(isset($team['team']['crest']))
                            <img src="{{ $team['team']['crest'] }}" alt="{{ $team['team']['tla'] ?? $team['team']['shortName'] ?? '' }}" class="w-5 h-5 md:w-9 md:h-9 object-contain" />
                        @else
                            <span class="w-5 h-5 md:w-9 md:h-9 rounded-full bg-gray-100 flex items-center justify-center text-[8px] md:text-xs font-bold text-gray-500 border border-gray-200 shadow-sm">{{ $team['team']['tla'] ?? '--' }}</span>
                        @endif
                        <span class="font-bold text-xs md:text-lg truncate max-w-[80px] sm:max-w-[150px] md:max-w-none">{{ $team['team']['shortName'] ?? $team['team']['name'] ?? 'Unknown' }}</span>
                    </div>
                </td>
                <td class="py-3 px-1 md:py-5 md:px-4 text-center font-medium text-gray-500">{{ $team['playedGames'] ?? 0 }}</td>
                <td class="py-3 px-1 md:py-5 md:px-4 text-center font-medium text-gray-500">{{ $team['won'] ?? 0 }}</td>
                <td class="py-3 px-1 md:py-5 md:px-4 text-center font-medium text-gray-500">{{ $team['draw'] ?? 0 }}</td>
                <td class="py-3 px-1 md:py-5 md:px-4 text-center font-medium text-gray-500">{{ $team['lost'] ?? 0 }}</td>
                <td class="py-3 px-1 md:py-5 md:px-4 text-center font-medium text-gray-500 hidden md:table-cell">{{ $team['goalsFor'] ?? 0 }}</td>
                <td class="py-3 px-1 md:py-5 md:px-4 text-center font-medium text-gray-500 hidden md:table-cell">{{ $team['goalsAgainst'] ?? 0 }}</td>
                <td class="py-3 px-1 md:py-5 md:px-4 text-center font-bold text-primary">{{ isset($team['goalDifference']) ? ($team['goalDifference'] > 0 ? '+' : '') . $team['goalDifference'] : 0 }}</td>
                <td class="py-3 px-1 md:py-5 md:px-4 text-center text-sm md:text-xl font-black font-outfit">{{ $team['points'] ?? 0 }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="py-8 px-6 text-center text-gray-500 font-medium">
                    Standings data is currently unavailable. Please check the API configuration.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>
