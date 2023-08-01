
<script src="https://cdn.tailwindcss.com"></script>
<script src="script.js"></script>

<body>
    <form action="/Namen" method="POST">
        @csrf
        
        Name: <input type="text" name="name"><br>

        <button type="submit">eingeben</button>
        </form>
   

    {{--@foreach ($namen1 as $name)
         {{$name->id}}
       @endforeach--}}
    

</body>