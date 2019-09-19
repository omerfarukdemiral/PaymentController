<?php include 'header.php';?>           
		   <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                           
                            
                              <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Makina Port</strong> Ayarları
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                           
										   <div class="row form-group">
                                              <div class="col col-md-3"> <label for="text-input" class=" form-control-label">IP Türü</label></div>
                                                <div class="col col-md-9">
                                                    <div class="form-check-inline form-check">
                                                        <label for="inline-checkbox1" class="form-check-label ">
                                                            <input type="checkbox" id="inline-checkbox1" name="inline-checkbox1" value="option1" class="form-check-input">Statik
                                                        </label>
														
                                                        <label for="inline-checkbox2" class="form-check-label ">
                                                            <input type="checkbox" id="inline-checkbox2" name="inline-checkbox2" value="option2" class="form-check-input">Dinamik
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-port-no" class=" form-control-label">Port No</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-port-no" name="text-port-no" placeholder="Port No Giriniz." class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-port-adi" class=" form-control-label">Port Adı </label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-port-adi" name="text-port-adi" placeholder="Port adını giriniz." class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Select</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="select" id="select" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <option value="1">Option #1</option>
                                                        <option value="2">Option #2</option>
                                                        <option value="3">Option #3</option>
                                                    </select>
                                                </div>
                                            </div>    
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Kaydet
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Sıfırla
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
							 <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Makine-Tabanca </strong> Ayarı
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="" method="post" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Türler</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="select" id="select" class="form-control">
                                                        <option value="0">Tabanca Türü Seçin</option>
                                                        <option value="1">Su</option>
                                                        <option value="2">Köpük</option>
                                                        <option value="3">Cila</option>
                                                    </select>
                                                </div>
                                            </div>
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-isim" class=" form-control-label">Tabanca Türü</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="email" id="hf-isim" name="hf-isim" placeholder="Enter Email..." class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-password" class=" form-control-label">Password</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="password" id="hf-password" name="hf-password" placeholder="Enter Password..." class="form-control">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Kaydet 
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Sıfırla
                                        </button>
                                    </div>
                                </div>                                
                            </div>
                          
                            
                            
                            
                           
                            
                            
                        </div>
                       <?php include 'footer.php';?>           
