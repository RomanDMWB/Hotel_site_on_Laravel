<footer>
        <ul class="contacts">
            @foreach($contacts as $item)
            <li>
                <p class='icon'>{!! $item['icon'] !!}</p>
                <p class="header">{{ $item['name'] }}:</p>
                <p class="content">{{ $item['content'] }}</p>
            </li>
            @endforeach
        </ul>
    <div class="organization-info">
        <p>© 2021 Hotel Room - All Rights Reserved - Made By <a>Roman</a></p>
    </div>
</footer>