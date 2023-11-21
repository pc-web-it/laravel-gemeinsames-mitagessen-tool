<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    }
                }
            }
        }
    </script>
   
</head>
<body>

<div>
    <div>
        @if(Auth::check())
        <form id="logout-form" action="{{ route('logout') }}" method="GET">
            @csrf
            <button class="absolute top-5 right-5 px-2 py-1 bg-gray-50 rounded-lg text-xl hover:scale-105 ease-in-out duration-300">Logout</button>
        </form>
        @endif
        <section class="bg-white ">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto ">
                <div class="w-full bg-gray-50 rounded-lg drop-shadow-xl  md:mt-0 sm:max-w-md xl:p-0  ">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                            Login
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="{{ route('authenticate') }}" method="post">
                            @csrf
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Username</label>
                                <input value="{{ old('name') }}" type="name" name="name" id="name" class="bg-gray-100 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5  " placeholder="Name" required="">
                                <div class="text-sm text-red-700">
                                    {{$errors->first('error')}}
                                </div>
                                
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-100 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " required="">
                                <div class="text-sm text-red-700">
                                    {{$errors->first('error')}}
                                </div>
                                
                                
                            </div>
                            
                            <button type="submit" class="w-full text-black bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Submit</button>
                            
                        </form>
                    </div>
                </div>
            </div>
          </section>
    </div>    
</div>
</body>
</html>




