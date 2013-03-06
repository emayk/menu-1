@include ('menu::common.header')

<p>This is a list of menus from the database. The runtime menus are not displayed here.</p>

<h2>Menu list</h2>

@include ('menu::common.messages')

<span class="frame"><a href="{{ \URL::route('admin.create')}}"><strong>Create new</strong></a></span>
@if (count($menus))
    <table>
        <colgroup>
            <col>
            <col width="30%">
        </colgroup>
        <thead>
            <tr>
                <th>Name</th>
                <th>Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
                <tr>
                    <td>
                        <a href="{{ \URL::route('admin.edit', array($menu->menu_name))}}">{{ $menu->menu_name }}</a>
                    </td>
                    <td>{{ strftime('%c', date_format(new DateTime($menu->updated_at, $timezone), 'U')) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $menus->links() }}
@else
    <p>No menus found in the database.</p>
@endif

@include ('menu::common.footer')
