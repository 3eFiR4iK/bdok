@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-12">
        <div class="glmen">
            <div>
                <nav>
                    <ul>
                        
                            <li>
                                    <a href="/addPart">
                                           <span>+Добавить мероприятие</span>
                                    </a>
                            </li>
                            <li>
                                   <a href="/kadet">
                                           <span>Кадеты</span>
                                    </a>
                            </li>
                    
                            <li>
                                    <a href="/part">
                                           <span>Мероприятия</span>
                                    </a>
                            </li>
                            <li>
                                    <a href="/class">
                                           <span>Классы</span>
                                    </a>
                            </li>
                    </ul>
                </nav>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
