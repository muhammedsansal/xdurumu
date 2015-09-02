              {{-- Daily --}}
              @if( ! $data['dailyList']->isEmpty())
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title"><span class="glyphicon glyphicon-calendar"></span>  {{ $city->name }} Günlük Hava Durumu</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="direct-chat-info clearfix">                        
                      <span class="direct-chat-timestamp ">güncelleme: {{ $data['dailyStat']->updated_at->diffForHumans()}}</span>
                  </div>
                   <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><i class="fa fa-fw fa-calendar-check-o"></i>Gün</th>
                        <th><i class="fa fa-fw fa-cloud iconic-font-20"></i>Durum</th>
                        <th><i class="ion ion-thermometer iconic-font-20" style="font-size: 20px;"></i> Sıcaklıklar</th>
                        <th><i class="ion ion-waterdrop iconic-font-20"></i> Nem Oranı</th>
                        <th><i class="ion ion-ios-rainy iconic-font-20" style="font-size: 20px;"></i> Yağış Miktarı</th>                       
                        <th><i class="ion ion-ios-flag iconic-font-20" style="font-size: 20px;"></i> Rüzgar</th>
                        <th><i class="ion ion-speedometer iconic-font-20" style="font-size: 20px;"></i> Basınç</th>                                                
                      </tr>
                    </thead>
                    <tbody>
                    {{-- Weather Hourly Stat List --}}
                    @foreach($data['dailyList'] as $dList)
                   
                      <tr>
                        <td>
                       
                          {{ Carbon\Carbon::createFromTimestampUTC($dList->dt)->formatLocalized('%A %d %B') }}
                        </td>
                        <td>
                          <img src="http://openweathermap.org/img/w/{{$dList->conditions[0]->icon}}d.png" alt="{{ $dList->conditions[0]->description }}">                        
                        </td>
                        <td>
                          <div class="description-block border-right">
                            <span class="badge bg-red"> {{ $dList->main->temp_max}} °C</span>
                            <span class="badge bg-default"> {{  $dList->main->temp }} °C</span>
                            <span class="badge bg-blue">{{ $dList->main->temp_min}} °C</span>
                          </div>
                        </td>
                      <td>                                               
                        {{$dList->main->humidity }}%</td>
                      </td>
                      <td>                                        
                           <?php 
                              $_rainVal = 0; 
                              
                              if(! is_null($dList->rain) ) {

                                $_rainVal = $dList->rain->getAttribute('3h');

                              } elseif ( ! is_null($dList->snow) )  {

                                $_rainVal = $dList->snow->getAttribute('3h');
                              }
                            ?>
                            {{ $_rainVal }} mm  
                        </td>
                        <td>                                               
                           {{ $dList->wind->speed }} m/s, <br> <i class="fa fa-fw fa-arrows"></i> {{ $dList->wind->deg}} °
                        </td>                        
                        <td>                                               
                           {{$dList->main->pressure }} hpa 
                        </td>
                      </tr>
                               
                    @endforeach
                    {{-- ./Weather Hourly Stat List --}}                
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th><i class="fa fa-fw fa-calendar-check-o"></i>Gün</th>
                        <th><i class="fa fa-fw fa-cloud iconic-font-20"></i>Durum</th>
                        <th><i class="ion ion-thermometer iconic-font-20" style="font-size: 20px;"></i> Sıcaklıklar</th>
                        <th><i class="ion ion-waterdrop iconic-font-20"></i> Nem Oranı</th>
                        <th><i class="ion ion-ios-rainy iconic-font-20" style="font-size: 20px;"></i> Yağış Miktarı</th>                       
                        <th><i class="ion ion-ios-flag iconic-font-20" style="font-size: 20px;"></i> Rüzgar</th>
                        <th><i class="ion ion-speedometer iconic-font-20" style="font-size: 20px;"></i> Basınç</th>    
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              @endif
