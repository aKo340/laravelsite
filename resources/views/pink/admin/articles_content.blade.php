@if($articles)
    <div id="content-page" class="content group">
        <div class="hentry group">
            <h2>{{ Lang::get('lv.added_articles') }}</h2>
            <div class="short-table white">
                <table style="width: 100%" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th class="align-left">ID</th>
                        <th>{{ Lang::get('lv.title') }}</th>
                        <th>{{ Lang::get('lv.text') }}</th>
                        <th>{{ Lang::get('lv.img') }}</th>
                        <th>{{ Lang::get('lv.category') }}</th>
                        <th>{{ Lang::get('lv.alias') }}</th>
                        <th>{{ Lang::get('lv.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($articles as $article)
                        <tr>
                            <td class="align-left">{{$article->id}}</td>
                            <td class="align-left">{!! Html::link(route('articles.edit',['articles'=>$article->alias]),$article->title) !!}</td>
                            <td class="align-left">{!! str_limit($article->text,200) !!}</td>
                            <td>
                                @if(isset($article->img->mini))
                                    {!! Html::image(asset(env('THEME')).'/images/articles/'.$article->img->mini) !!}
                                @endif
                            </td>
                            <td>{{$article->category->title}}</td>
                            <td>{{$article->alias}}</td>
                            <td>
                                {!! Form::open(['url' => route('articles.destroy',['articles'=>$article->alias]),'class'=>'form-horizontal','method'=>'POST']) !!}
                                {{ method_field('DELETE') }}
                                {!! Form::button('Dzēst', ['class' => 'btn btn-french-5','type'=>'submit']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            {!! Html::link(route('articles.create'),'Pievienot materiālu',['class' => 'btn btn-the-salmon-dance-3']) !!}



        </div>
        <!-- START COMMENTS -->
        <div id="comments">
        </div>
        <!-- END COMMENTS -->
    </div>
@endif