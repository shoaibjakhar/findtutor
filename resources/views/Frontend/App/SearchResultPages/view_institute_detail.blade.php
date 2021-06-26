@extends('Frontend/App/layout')
@section('user_layout')



<div class="container" style="margin-top: 110px;margin-bottom: 30px">
    <h1>{{$search_institute->name}} {{$search_institute->first_name}}</h1>
    <div class="row">

        <div class="col-md-5">
            <a href="#"><img  src="/public/images/{{$search_institute->image}}" style="width: 100%;height: 400px"></a>
        </div>

        <div class="col-md-7">
            <div class="row">
                <div class="col-md-7">
                    
            <table>
            <tr>
                <th>Contact # :</th>
                <td><a href="tel:+{{$search_institute->country_code}}{{$search_institute->phone_no}}">+{{$search_institute->country_code}}{{$search_institute->phone_no}}</a></td>
            </tr>

            <tr>
                <th>Email: </th>
                <td><a href="mailto:{{$search_institute->email}}">{{$search_institute->email}}</a></td>
            </tr>  
             <tr>
                <th>Price :</th>
                <td>$10</td>
            </tr> 
            </table>

                </div>
                <div class="col-md-5">
                    <a href="#"><button class="btn btn-primary">Entrolled</button></a>
                </div>
            </div>

            
            <table class="card" style="padding: 10px;margin-top: 30px">
                <tr><th><h1>Description</h1></th></tr>
                <tr><td style="text-align: justify;">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book.Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book.Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book.</td></tr>
            </table>
        </div>
    </div>
</div>




@endsection