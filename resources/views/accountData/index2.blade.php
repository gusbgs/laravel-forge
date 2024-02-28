<script type="text/javascript">
var newData = [
  @foreach($account2 as $item1)
  {
    @php $on = 1; @endphp
    id: {{ $item1->id }},
    title: '{{ $item1->number }}' + '-' + '{{ $item1->name }}',

    @if (count(${'item'.$on}->children) > 0)
    isSelectable: false,
    @php $in = 2; $on = $in - 1;
    @endphp
    subs: [
      @foreach (${'item'.$on}->children as ${'item'.$in})
      {
        id: {{ ${'item'.$in}->id }},
        title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

        // Paste Kesini
        @if (count(${'item'.$in}->children) > 0)
        isSelectable: false,
        @php $in = 3; $on = $in - 1;
        @endphp
        subs: [
          @foreach (${'item'.$on}->children as ${'item'.$in})
          {
            id: {{ ${'item'.$in}->id }},
            title: '{{ ${"item".$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

            // Paste Kesini
            @if (count(${'item'.$in}->children) > 0)
            isSelectable: false,
            @php $in = 4; $on = $in - 1;
            @endphp
            subs: [
              @foreach (${'item'.$on}->children as ${'item'.$in})
              {
                id: {{ ${'item'.$in}->id }},
                title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                // Paste Kesini
                @if (count(${'item'.$in}->children) > 0)
                isSelectable: false,
                @php $in = 5; $on = $in - 1;
                @endphp
                subs: [
                  @foreach (${'item'.$on}->children as ${'item'.$in})
                  {
                    id: {{ ${'item'.$in}->id }},
                    title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                    // Paste Kesini
                    @if (count(${'item'.$in}->children) > 0)
                    isSelectable: false,
                    @php $in = 6; $on = $in - 1;
                    @endphp
                    subs: [
                      @foreach (${'item'.$on}->children as ${'item'.$in})
                      {
                        id: {{ ${'item'.$in}->id }},
                        title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                        // Paste Kesini
                        @if (count(${'item'.$in}->children) > 0)
                        isSelectable: false,
                        @php $in = 7; $on = $in - 1;
                        @endphp
                        subs: [
                          @foreach (${'item'.$on}->children as ${'item'.$in})
                          {
                            id: {{ ${'item'.$in}->id }},
                            title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                            // Paste Kesini
                            @if (count(${'item'.$in}->children) > 0)
                            isSelectable: false,
                            @php $in = 8; $on = $in - 1;
                            @endphp
                            subs: [
                              @foreach (${'item'.$on}->children as ${'item'.$in})
                              {
                                id: {{ ${'item'.$in}->id }},
                                title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                // Paste Kesini
                                @if (count(${'item'.$in}->children) > 0)
                                isSelectable: false,
                                @php $in = 9; $on = $in - 1;
                                @endphp
                                subs: [
                                  @foreach (${'item'.$on}->children as ${'item'.$in})
                                  {
                                    id: {{ ${'item'.$in}->id }},
                                    title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                    // Paste Kesini
                                    @if (count(${'item'.$in}->children) > 0)
                                    isSelectable: false,
                                    @php $in = 10; $on = $in - 1;
                                    @endphp
                                    subs: [
                                      @foreach (${'item'.$on}->children as ${'item'.$in})
                                      {
                                        id: {{ ${'item'.$in}->id }},
                                        title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                        // Paste Kesini
                                        @if (count(${'item'.$in}->children) > 0)
                                        isSelectable: false,
                                        @php $in = 11; $on = $in - 1;
                                        @endphp
                                        subs: [
                                          @foreach (${'item'.$on}->children as ${'item'.$in})
                                          {
                                            id: {{ ${'item'.$in}->id }},
                                            title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                            // Paste Kesini
                                            @if (count(${'item'.$in}->children) > 0)
                                            isSelectable: false,
                                            @php $in = 12; $on = $in - 1;
                                            @endphp
                                            subs: [
                                              @foreach (${'item'.$on}->children as ${'item'.$in})
                                              {
                                                id: {{ ${'item'.$in}->id }},
                                                title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                                // Paste Kesini
                                                @if (count(${'item'.$in}->children) > 0)
                                                isSelectable: false,
                                                @php $in = 13; $on = $in - 1;
                                                @endphp
                                                subs: [
                                                  @foreach (${'item'.$on}->children as ${'item'.$in})
                                                  {
                                                    id: {{ ${'item'.$in}->id }},
                                                    title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                                    // Paste Kesini
                                                    @if (count(${'item'.$in}->children) > 0)
                                                    isSelectable: false,
                                                    @php $in = 14; $on = $in - 1;
                                                    @endphp
                                                    subs: [
                                                      @foreach (${'item'.$on}->children as ${'item'.$in})
                                                      {
                                                        id: {{ ${'item'.$in}->id }},
                                                        title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                                        // Paste Kesini
                                                        @if (count(${'item'.$in}->children) > 0)
                                                        isSelectable: false,
                                                        @php $in = 15; $on = $in - 1;
                                                        @endphp
                                                        subs: [
                                                          @foreach (${'item'.$on}->children as ${'item'.$in})
                                                          {
                                                            id: {{ ${'item'.$in}->id }},
                                                            title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                                            // Paste Kesini
                                                            @if (count(${'item'.$in}->children) > 0)
                                                            isSelectable: false,
                                                            @php $in = 16; $on = $in - 1;
                                                            @endphp
                                                            subs: [
                                                              @foreach (${'item'.$on}->children as ${'item'.$in})
                                                              {
                                                                id: {{ ${'item'.$in}->id }},
                                                                title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                                                // Paste Kesini
                                                                @if (count(${'item'.$in}->children) > 0)
                                                                isSelectable: false,
                                                                @php $in = 17; $on = $in - 1;
                                                                @endphp
                                                                subs: [
                                                                  @foreach (${'item'.$on}->children as ${'item'.$in})
                                                                  {
                                                                    id: {{ ${'item'.$in}->id }},
                                                                    title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                                                    // Paste Kesini
                                                                    @if (count(${'item'.$in}->children) > 0)
                                                                    isSelectable: false,
                                                                    @php $in = 18; $on = $in - 1;
                                                                    @endphp
                                                                    subs: [
                                                                      @foreach (${'item'.$on}->children as ${'item'.$in})
                                                                      {
                                                                        id: {{ ${'item'.$in}->id }},
                                                                        title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                                                        // Paste Kesini
                                                                        @if (count(${'item'.$in}->children) > 0)
                                                                        isSelectable: false,
                                                                        @php $in = 19; $on = $in - 1;
                                                                        @endphp
                                                                        subs: [
                                                                          @foreach (${'item'.$on}->children as ${'item'.$in})
                                                                          {
                                                                            id: {{ ${'item'.$in}->id }},
                                                                            title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                                                            // Paste Kesini
                                                                            @if (count(${'item'.$in}->children) > 0)
                                                                            isSelectable: false,
                                                                            @php $in = 20; $on = $in - 1;
                                                                            @endphp
                                                                            subs: [
                                                                              @foreach (${'item'.$on}->children as ${'item'.$in})
                                                                              {
                                                                                id: {{ ${'item'.$in}->id }},
                                                                                title: '{{ ${'item'.$in}->number }}' + '-' +  '{{ ${'item'.$in}->name }}',

                                                                                // Paste Kesini

                                                                              },
                                                                              @php $in = 20; $on = $in - 1;
                                                                              @endphp
                                                                              @endforeach
                                                                            ],
                                                                            @endif
                                                                          },
                                                                          @php $in = 19; $on = $in - 1;
                                                                          @endphp
                                                                          @endforeach
                                                                        ],
                                                                        @endif
                                                                      },
                                                                      @php $in = 18; $on = $in - 1;
                                                                      @endphp
                                                                      @endforeach
                                                                    ],
                                                                    @endif
                                                                  },
                                                                  @php $in = 17; $on = $in - 1;
                                                                  @endphp
                                                                  @endforeach
                                                                ],
                                                                @endif
                                                              },
                                                              @php $in = 16; $on = $in - 1;
                                                              @endphp
                                                              @endforeach
                                                            ],
                                                            @endif
                                                          },
                                                          @php $in = 15; $on = $in - 1;
                                                          @endphp
                                                          @endforeach
                                                        ],
                                                        @endif
                                                      },
                                                      @php $in = 14; $on = $in - 1;
                                                      @endphp
                                                      @endforeach
                                                    ],
                                                    @endif
                                                  },
                                                  @php $in = 13; $on = $in - 1;
                                                  @endphp
                                                  @endforeach
                                                ],
                                                @endif
                                              },
                                              @php $in = 12; $on = $in - 1;
                                              @endphp
                                              @endforeach
                                            ],
                                            @endif
                                          },
                                          @php $in = 11; $on = $in - 1;
                                          @endphp
                                          @endforeach
                                        ],
                                        @endif
                                      },
                                      @php $in = 10; $on = $in - 1;
                                      @endphp
                                      @endforeach
                                    ],
                                    @endif
                                  },
                                  @php $in = 9; $on = $in - 1;
                                  @endphp
                                  @endforeach
                                ],
                                @endif
                              },
                              @php $in = 8; $on = $in - 1;
                              @endphp
                              @endforeach
                            ],
                            @endif
                          },
                          @php $in = 7; $on = $in - 1;
                          @endphp
                          @endforeach
                        ],
                        @endif
                      },
                      @php $in = 6; $on = $in - 1;
                      @endphp
                      @endforeach
                    ],
                    @endif
                  },
                  @php $in = 5; $on = $in - 1;
                  @endphp
                  @endforeach
                ],
                @endif
              },
              @php $in = 4; $on = $in - 1;
              @endphp
              @endforeach
            ],
            @endif
          },
          @php $in = 3; $on = $in - 1;
          @endphp
          @endforeach
        ],
        @endif

      },
      @php $in = 2; $on = $in - 1;
      @endphp
      @endforeach
    ],
    @endif
  },
@endforeach
];
</script>
