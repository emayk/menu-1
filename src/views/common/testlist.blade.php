@if (isset($menuTestList))

    <ul <?php echo isset($menuTestType) ? 'class="horizontal"' : ''?>>
        @if (isset($menuTestType))
            <li><a href="{{ URL::route('tests.index') }}">« Back to the test list</a></li>
        @endif
        @foreach ($menuTestList as $test)
            <li>{{ $test }}</li>
        @endforeach
    </ul>
    <?php echo isset($menuTestType) ? '<hr>' : ''?>
@endif
