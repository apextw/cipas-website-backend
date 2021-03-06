<!DOCTYPE html>
<!--[if IE 9]> <html lang="zh-tw" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zh-tw">
<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<head>
	<?php echo $headHtml;?>
	<link href="/public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
	<link href="/public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
	<link href="/public/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
	<link href="/public/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
	</head>
	<!-- END HEAD -->
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
		<div class="page-wrapper">
			<?php echo $headerHtml;?>
			<!-- BEGIN HEADER & CONTENT DIVIDER -->
			<div class="clearfix"> </div>
			<!-- END HEADER & CONTENT DIVIDER -->
			<!-- BEGIN CONTAINER -->
			<div class="page-container">
				<?php echo $sidebarHtml;?>
				<!-- BEGIN CONTENT -->
				<div class="page-content-wrapper">
					<!-- BEGIN CONTENT BODY -->
					<div class="page-content">
						<!-- BEGIN PAGE HEADER-->
						<!-- BEGIN PAGE BAR -->
						<div class="page-bar">
							<ul class="page-breadcrumb">
								<li>
									<a href="/home">Home</a>
									<i class="fa fa-circle"></i>
								</li>
								<li>
									<span><?php echo $unit;?>-修改</span>
								</li>
							</ul>
						</div>
						<!-- END PAGE BAR -->
						<!-- BEGIN PAGE TITLE-->
						<h1 class="page-title"> <?php echo $unit;?>-修改 </h1>
						<!-- END PAGE TITLE-->
						<!-- END PAGE HEADER-->
						<?php echo $alertsHtml;?>
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet light bordered form-fit">
									<div class="portlet-title">
										<div class="caption">
											<span class="caption-subject font-blue-hoki bold uppercase"><?php echo $unit;?>-修改</span>
											<span class="caption-helper"><?php echo isset($result[$abrv.'account']) ? $result[$abrv.'account'] : '';?></span>
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form id="formPost" action="" class="formPost form-horizontal form-bordered form-row-stripped" method="post">
											<input type="hidden" id="<?php echo $this->security->get_csrf_token_name()?>" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
											<input type="hidden" name="op" value="upd">
											<input type="hidden" name="HTTP_REFERER" value="<?php echo $httpGetParams;?>">
											<div class="form-body">
												<div class="form-group">
													<label class="control-label col-md-3">標題</label>
													<div class="col-md-9">
														<input type="text" placeholder="請填寫標題" class="form-control" id="<?php echo $abrv;?>title" name="<?php echo $abrv;?>title" aria-required="true" value="<?php echo isset($result[$abrv.'title']) ? stripslashes($result[$abrv.'title']) : '';?>" />
													</div>
												</div>
                                                <div class="form-group">
													<label class="control-label col-md-3">內文</label>
													<div class="col-md-9">
                                                        <textarea class="ckeditor form-control" id="content" name="<?php echo $abrv;?>content" rows="6" data-error-container="#<?php echo $abrv;?>content"><?php echo isset($result[$abrv.'content']) ? stripslashes($result[$abrv.'content']) : '';?></textarea>
                                                        <div id="<?php echo $abrv;?>content"></div>
                                                        內文若有建立表格或上傳圖片，請將圖片寬度設定為 100%
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">上傳附件</label>
													<div class="col-md-9">
														<table class="table table-striped table-bordered table-hover">
															<thead>
																<tr role="row">
																	<th width="50%">檔案標題</th>
																	<th width="30%">檔案</th>
																	<th width="20%">刪除</th>
																</tr>
																<tbody id="file_tbody">
																<?php foreach($resultFile as $i=>$file){?>
																	<tr id="fileRow_<?php echo $i+1?>">
																		<input type="hidden" id="<?php echo $abrv;?>file_id[]" name="<?php echo $abrv;?>file_id[]" aria-required="true" value="<?php echo isset($file[$abrv.'file_id']) ? $file[$abrv.'file_id'] : '';?>" />
																		<td width="50%">
																			<input type="text" placeholder="請填寫檔案標題" class="form-control" id="<?php echo $abrv;?>file_title[]" name="<?php echo $abrv;?>file_title[]" aria-required="true" value="<?php echo isset($file[$abrv.'file_title']) ? stripslashes($file[$abrv.'file_title']) : '';?>" />
																		</td>
																		<td width="30%">
					                                                        <div class="fileinput fileinput-new" id="file" data-provides="fileinput">
					                                                            <span class="btn green btn-file">
					                                                                <span class="fileinput-new"> 請選擇檔案 </span>
					                                                                <span class="fileinput-exists"> 重選 </span>
					                                                                <input type="file" name="tmp_file" id="tmp_file">
					                                                                <input type="hidden" name="tmp_filename[]" id="tmp_filename">
                                                                					<input type="hidden" name="tmp_file_url[]" id="tmp_file_url">
					                                                                <input type="hidden" class="fileinput-name" name="<?php echo $abrv;?>file_name[]" value="<?php echo isset($file[$abrv.'file_name']) ? $file[$abrv.'file_name'] : '';?>">
					                                                            </span>
					                                                            <span class="fileinput-filename"><?php echo isset($file[$abrv.'file_orig_name']) ? $file[$abrv.'file_orig_name'] : '';?></span>
					                                                        </div>
																		</td>
																		<td width="20%">
																			<a class="btn red delete" onclick="delFileRow(<?php echo $i+1?>)">
								                                                <i class="fa fa-trash"></i>
								                                                <span> 刪除 </span>
																			</a>
																		</td>
																	</tr>
																<?php }?>
																</tbody>
															</thead>
														</table>
														<a onclick="addFile()"  class="btn green"></i> 新增附件</a>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3">分享說明</label>
												<div class="col-md-9">
													<input type="text" placeholder="請填寫分享說明" class="form-control" id="<?php echo $abrv;?>meta_description" name="<?php echo $abrv;?>meta_description" aria-required="true" value="<?php echo isset($result[$abrv.'meta_description']) ? stripslashes($result[$abrv.'meta_description']) : '';?>" />
												</div>
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-xs-6 col-sm-4">
														<button type="submit" class="btn green"><i class="fa fa-check"></i> 送出</button>
														<button type="button" class="btn default" data-toggle="modal" href="#cancel">取消</button>
													</div>
													<div class="col-xs-6 col-sm-4">
														<a href="<?php echo $this->config->item('frontEndUrl').$frontEndUrl; ?>" class="btn yellow"> 預覽</a>
														如欲使用預覽功能請先送出
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
									</div>
								</div>
								<!-- END EXAMPLE TABLE PORTLET-->
							</div>
						</div>
						<div class="row">
							<?php echo $this->pagination->create_links();?>
						</div>
					</div>
					<!-- END CONTENT BODY -->
				</div>
				<!-- END CONTENT -->
			</div>
			<!-- END CONTAINER -->
			<!-- BEGIN FOOTER -->
			<?php echo $footerHtml;?>
			<!-- END FOOTER -->
		</div>
		<?php echo $templateHtml;?>
		<?php echo $scriptsHtml;?>
		<script src="/public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
		<script src="/public/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="/public/assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
		<script src="/public/assets/global/plugins/moment.min.js" type="text/javascript"></script>
		<script src="/public/js/jquery.ajaxfileupload.js" type="text/javascript" ></script>
		<script src="/public/js/jquery.blockUI.js" type="text/javascript"></script>
		<script src="/public/js/uploadFile.js" type="text/javascript"></script>
		<script src="/public/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script src="/public/ckfinder/ckfinder.js" type="text/javascript"></script>
		<?php echo $blockAlertsHtml;?>
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="/public/js/main/<?php echo $controllerName;?>.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
	</body>