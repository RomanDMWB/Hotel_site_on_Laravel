<?php header("Content-Type: text/html; charset=utf-8"); ?>

@extends('layouts.admin_page_layout')

@section('content')
<form action="{{ url('admin/booking/update/'.$id) }}" method="post">
    @csrf
    @method('PUT')
    <!-- Booking Keys Inputs -->
    @foreach($booking as $item=>$key)
    @if($item!=='place' AND $item!='cost' AND $item!='type')
    <div class="form-group">
        <label>{{ $item }}:</label>
        <input type="text" name="{{ $item }}" class="form-control" required value="{{ $key }}">
    </div>
    @endif
    @endforeach
    <!-- Select Room Type -->
    @if($types)
    <div class="form-group">
        <label for="">Type</label>
        <select id='types' name='type'>
            @foreach($types as $item)
            <option <?php if($booking['type']==$item['name']) echo 'selected' ?> value="{{ $item['name'] }}" onselect="">{{ $item['name'] }}</option>
            @endforeach
        </select>
    </div>
    @endif
    <!-- Select Place -->
    @if($places)
    <div class="form-group">
        <label for="">Place</label>
        <select id="places" name='place'>
            @foreach($places as $item)
            <option <?php if($booking['place']==$item['number']) echo 'selected' ?> value="{{ $item['number'] }}">{{ $item['number'] }}</option>
            @endforeach
        </select>
    </div>
    @else
    <p class="not-found">Not Found</p>
    @endif
    <div class="form-group">
        <button type="submit" class="btn">Обновить</button>
    </div>
</form>
<?php 
use App\Http\Controllers\TableController;
$database = app('firebase.database');
$data = array();
$places = TableController::getPlaces($database);
$types = TableController::getRooms($database);
foreach($types as $key=>$type){
    $typePlaces = array();
    foreach($places as $key=>$value ){
        if($value['type']===$type['name'])
            $typePlaces[] = $value['number'];
    }
    $data[$type['name']]=$typePlaces;
}
?>
<script>
    const selectTypes = document.getElementById('types');
    const selectPlaces = document.getElementById('places');
	const data = {};
    let array;
    @foreach($data as $key => $value)
    array = [];
    @foreach($value as $numkey => $num)
    array.push(<?php echo($num) ?>);
    @endforeach
    data["<?php echo($key) ?>"] = array;
    @endforeach
    console.log(data);

    selectTypes.addEventListener('change', (e) => {
		const type = selectTypes.value;
		while (selectPlaces.hasChildNodes()) {
			selectPlaces.removeChild(selectPlaces.lastChild);
		}
		data[type].forEach(place => {
			const option = document.createElement('option');
			option.value = place;
			option.textContent = place;
			selectPlaces.append(option);
		});
    })

</script>
@endsection
