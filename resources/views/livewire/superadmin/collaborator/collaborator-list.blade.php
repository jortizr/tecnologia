<div>
    <ul>
    @foreach ($collaborators as $collaborator)

            <li>{{$collaborator->names}} {{$collaborator->last_name}}</li>

    @endforeach
    </ul>
</div>
