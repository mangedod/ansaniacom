<!-- START Template Main -->
<section id="main" role="main">
    <!-- START Template Container -->
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header page-header-block">
            <div class="page-header-section">
                <h4 class="title semibold">Dashboard</h4>
            </div>
           
        </div>
        <!-- Page Header -->

        <div class="row">
        	
            <div class="col-md-12">
                             
            
                <!-- Top Stats -->
                <div class="row">
                    
                    <div class="col-sm-3">
                        <!-- START Statistic Widget -->
                        <div class="table-layout">
                            <div class="col-xs-4 panel bgcolor-info">
                                <div class="ico-users3 fsize24 text-center"></div>
                            </div>
                            <div class="col-xs-8 panel">
                                <div class="panel-body text-center">
                                    <h4 class="semibold nm">
                                    <?php
                                        $jmlpeserta = sql_get_var("select count(*) as jml from tbl_member");
                                        echo number_format($jmlpeserta,0,",",".");
                                    ?>
                                    </h4>
                                    <p class="semibold text-muted mb0 mt5">MEMBER</p>
                                </div>
                            </div>
                        </div>
                        <!--/ END Statistic Widget -->
                    </div>

                     <div class="col-sm-3">
                        <!-- START Statistic Widget -->
                        <div class="table-layout">
                            <div class="col-xs-4 panel bgcolor-warning">
                                <div class="ico-user22 fsize24 text-center"></div>
                            </div>
                            <div class="col-xs-8 panel">
                                <div class="panel-body text-center">
                                    <h4 class="semibold nm">
                                    <?php
                                        $jmlsub = sql_get_var("select count(*) as jml from tbl_subscriber");
                                        echo $jmlsub;
                                    ?>
                                    </h4>
                                    <p class="semibold text-muted mb0 mt5">SUBCRIBER</p>
                                </div>
                            </div>
                        </div>
                        <!--/ END Statistic Widget -->
                    </div>
                    
                    <div class="col-sm-3">
                        <!-- START Statistic Widget -->
                        <div class="table-layout">
                            <div class="col-xs-4 panel bgcolor-danger">
                                <div class="ico-user22 fsize24 text-center"></div>
                            </div>
                            <div class="col-xs-8 panel">
                                <div class="panel-body text-center">
                                    <h4 class="semibold nm">
                                    <?php
                                        $jmlticket = sql_get_var("select count(*)  as jml from tbl_ticketing where status='0'");
                                        echo $jmlticket;
                                    ?>
                                    </h4>
                                    <p class="semibold text-muted mb0 mt5">TICKETING</p>
                                </div>
                            </div>
                        </div>
                        <!--/ END Statistic Widget -->
                    </div>
                   
                    <div class="col-sm-3">
                        <!-- START Statistic Widget -->
                        <div class="table-layout">
                            <div class="col-xs-4 panel bgcolor-primary">
                                <div class="ico-newspaper fsize24 text-center"></div>
                            </div>
                            <div class="col-xs-8 panel">
                                <div class="panel-body text-center">
                                    <h4 class="semibold nm">
                                    <?php
                                        $jmlorder = sql_get_var("select count(*) as jml from tbl_transaksi where status='1'");
                                        echo number_format($jmlorder,0,",",".");
                                    ?>
                                    </h4>
                                    <p class="semibold text-muted mb0 mt5">NEW ORDERS</p>
                                </div>
                            </div>
                        </div>
                        <!--/ END Statistic Widget -->
                    </div>
            
                </div>
                <!--/ Top Stats -->

                <!-- Website States -->
                <div class="row">
                    <div class="col-md-6">
                        <!-- START panel -->
                        <div class="panel mt10">
                            <?php
                                $thn    = date("Y");

                                $range      = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
                                $jrange     = count($range);
                                $datadetail = array();
                                
                                $total = 0;
                                
                                for($c=0;$c<$jrange;$c++)
                                {
                                    if($c<10) $bln = "0".$c;
                                    else $bln = $c;
                                    
                                    $bulan = "$thn-$bln";
                                    $nama  = $range[$c];

                                    $jumtrans      = sql_get_var("select count(*) as jml from tbl_transaksi where status='3' and substring(tanggaltransaksi,1,7)='$bulan'");
                                    $dtthnprod[$c] = array("nama"=>$nama,"jumlah"=>$jumtrans);
                                }
                                ?>
                            
                            <!--/ panel-toolbar -->
                            <!-- panel-body -->
                            <div class="panel-body">
                                <script type="text/javascript" src="./librari/fchart/js/fusioncharts.js"></script>
                                <script type="text/javascript" src="./librari/fchart/js/themes/fusioncharts.theme.zune.js"></script>
                                <script type="text/javascript">
                                  FusionCharts.ready(function(){
                                    var revenueChart = new FusionCharts({
                                        "type": "column2d",
                                        "renderAt": "chartContainer_cab",
                                        "width": "100%",
                                        "height": "450",
                                         "border": "1",
                                        "dataFormat": "json",
                                        "dataSource":  {
                                          "chart": {
                                            "caption": "Statistik Penjualan Pertahun",
                                            "subCaption": "<?php echo $title; ?> Tahun <?php echo $thn; ?>",
                                            "xAxisName": "Bulan",
                                            "yAxisName": "Jumlah Penjualan",
                                            "theme": "zune"
                                         },
                                         "data": [
                                            <?php
                                            foreach ($dtthnprod as $hs) 
                                            {
                                            ?>
                                            {
                                               "label": "<?php echo $hs['nama'] ?>",
                                               "value": "<?php echo $hs['jumlah'] ?>"
                                            },
                                            <?php 
                                            } ?>
                                          ]
                                      }
                                
                                  });
                                revenueChart.render();
                                })
                                </script>
                                 <div id="chartContainer_cab">FusionCharts XT will load here!</div>
                            </div>
                           
                        </div>
                        <!--/ END panel -->
                    </div>
                    <div class="col-md-6">
                        <!-- START panel -->
                        <div class="panel mt10">
                            <?php
                                $thn    = date("Y");

                                $range = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
                                $jrange = count($range);
                                
                                $datadetail = array();
                                $i = 1;
                                
                                $total = 0;
                                
                                for($c=0;$c<$jrange;$c++)
                                {
                                    if($c<10) $bln = "0".$c;
                                    else $bln = $c;
                                    
                                    $bulan = "$thn-$bln";
                                    $nama = $range[$c];
                                                                       
                                    $mysql = "select count(*) as jumlah from tbl_member where substring(usercreateddate,1,7)='$bulan'";
                                    $hasil = sql( $mysql);
                                    while ($data =  sql_fetch_data($hasil))
                                    {   
                                        $jumlah = $data['jumlah'];
                                        $total = $total+$jumlah;
                                            
                                        $datadetail[$i] = array("id"=>$i,"no"=>$i,"nama"=>$nama,"jumlah"=>$jumlah);
                                        $i++;
                                    }
                                    sql_free_result($hasil);
                                }
                                ?>
                            
                            <!--/ panel-toolbar -->
                            <!-- panel-body -->
                            <div class="panel-body">
                                <script type="text/javascript" src="./librari/fchart/js/fusioncharts.js"></script>
                                <script type="text/javascript" src="./librari/fchart/js/themes/fusioncharts.theme.zune.js"></script>
                                <script type="text/javascript">
                                  FusionCharts.ready(function(){
                                    var revenueChart = new FusionCharts({
                                        "type": "column2d",
                                        "renderAt": "chartContainer",
                                        "width": "100%",
                                        "height": "450",
                                         "border": "1",
                                        "dataFormat": "json",
                                        "dataSource":  {
                                          "chart": {
                                            "caption": "Statistik Jumlah Member Perbulan",
                                            "subCaption": "<?php echo $title; ?> Tahun <?php echo $thn; ?>",
                                            "xAxisName": "Bulan",
                                            "yAxisName": "Jumlah Member",
                                            "theme": "zune"
                                         },
                                         "data": [
                                            <?php
                                            foreach ($datadetail as $k) 
                                            {
                                            ?>
                                            {
                                               "label": "<?php echo $k['nama'] ?>",
                                               "value": "<?php echo $k['jumlah'] ?>"
                                            },
                                            <?php 
                                            } ?>
                                          ]
                                      }
                                
                                  });
                                revenueChart.render();
                                })
                                </script>
                                 <div id="chartContainer">FusionCharts XT will load here!</div>
                            </div>
                           
                        </div>
                        <!--/ END panel -->
                    </div>
                </div>
                <!--/ Website States -->
                
            </div>
            <!--/ END Left Side -->

           
        </div>
    </div>
    <!--/ END Template Container -->
