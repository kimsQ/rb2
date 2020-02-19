<form name="writeForm" method="post" action="<?php echo $g['s']?>/" role="form" class="rb-post-write">
  <input type="hidden" name="r" value="<?php echo $r?>">
  <input type="hidden" name="m" value="<?php echo $m?>">
  <input type="hidden" name="a" value="write">
  <input type="hidden" name="uid" value="<?php echo $R['uid']?>">
  <input type="hidden" name="category_members" value="">
  <input type="hidden" name="list_members" value="">
  <input type="hidden" name="upload" id="upfilesValue" value="<?php echo $R['upload']?>">
  <input type="hidden" name="member" value="<?php echo $R['member']?>">
  <input type="hidden" name="goods" value="<?php echo $R['goods']?>">
  <input type="hidden" name="featured_img" value="<?php echo $R['featured_img'] ?>">
  <input type="hidden" name="html" value="HTML">
  <input type="hidden" name="display">
  <input type="hidden" name="dis_rating">
  <input type="hidden" name="dis_like">
  <input type="hidden" name="dis_comment">
  <input type="hidden" name="dis_listadd">

  <header class="d-flex align-items-center py-3 px-4">

    <a href="<?php echo RW('mod=dashboard&page=post')?>" title="포스트 관리" class="mr-2" data-toggle="tooltip">
      <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i>
    </a>

    <div class="form-group mb-0" style="width:71.5%">
      <label class="sr-only">제목</label>
      <input type="text" name="subject" value="<?php echo stripslashes($R['subject'])?>" class="form-control form-control-lg meta" placeholder="제목없는 포스트">
    </div>
  </header>

  <main>

    <?php
      $d['theme']['show_edittoolbar'] = true;
      $__SRC__ = getContents($R['content'],$R['html']);
      include $g['path_plugin'].'ckeditor5/import.desktop.post.php';
    ?>

  </main><!-- /.col -->

  <aside class="border-top">
    <div class="inner">
      <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">기본</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo !$cid?' disabled':'' ?>" id="home-tab" data-toggle="tab" href="#advan" role="tab" aria-controls="info" aria-selected="true">고급</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo !$cid?' disabled':'' ?>" id="attach-tab" data-toggle="tab" href="#attach" role="tab" aria-controls="attach" aria-selected="false">파일</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo !$cid?' disabled':'' ?>" id="profile-tab" data-toggle="tab" href="#link" role="tab" aria-controls="link" aria-selected="false">링크</a>
        </li>
        <?php if ($d['post']['goodsperm']): ?>
        <li class="nav-item">
          <a class="nav-link<?php echo !$cid?' disabled':'' ?>" id="contact-tab" data-toggle="tab" href="#goods" role="tab" aria-controls="goods" aria-selected="false">상품</a>
        </li>
        <?php endif; ?>
      </ul>
      <div class="tab-content p-3">
        <div class="tab-pane show active" id="basic" role="tabpanel" aria-labelledby="home-basic">

          <?php if (!$cid): ?>
          <fieldset id="quick-write" class="mt-4">
            <input type="hidden" name="attachfiles[]" value="">
            <input type="hidden" name="format" value="">
            <div class="form-group">
              <label>외부링크</label>
              <div class="input-group">
                <textarea class="form-control" placeholder="URL 입력"></textarea>
                <div class="input-group-append">
                  <button class="btn btn-white text-primary" type="button">불러오기</button>
                </div>
              </div>
              <small class="form-text text-muted">
                외부링크가 포함되는 경우 URL 입력후 불러오기를 해주세요. <br>링크의 메타정보를 불러와 빠르게 포스트를 셋팅합니다.
              </small>
            </div>
          </fieldset>
          <?php endif; ?>

          <?php if ($cid): ?>
          <div class="form-group">
            <label class="sr-only">요약설명</label>
            <textarea class="form-control meta" rows="3" name="review" placeholder="요약설명을 입력하세요"><?php echo $R['review']?></textarea>
            <small class="form-text text-muted">100자 이내로 요약설명을 입력하세요.</small>
          </div>

          <div class="form-group mt-4">
            <label class="sr-only">태그</label>
            <textarea class="form-control meta" rows="2" name="tag" placeholder="태그를 입력하세요"><?php echo $R['tag']?></textarea>
            <small class="form-text text-muted">콤마(,)로 구분하여 입력해 주세요.</small>
          </div>

          <div class="form-group">
            <label class="sr-only">리스트</label>

            <div class="dropdown dropdown-filter" data-role="list-selector">
              <button class="btn btn-white btn-block dropdown-toggle d-flex justify-content-between align-items-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                리스트 선택
                <div class="mr-4"><span class="badge badge-primary" data-role="list_num"></span></div>
              </button>
              <div class="dropdown-menu shadow pt-0" style="width: 320px">

                <div class="dropdown-body p-3" style="max-height: 300px;overflow:auto">

                  <?php
                    $listque	= 'mbruid='.$my['uid'];
                    $_RCD = getDbArray($table['postlist'],$listque,'*','gid','asc',30,1);
                    $NUM = getDbRows($table['postlist'],$listque);
                  ?>
                  <?php foreach($_RCD as $_R):?>
                  <?php $is_list =  getDbRows($table[$m.'list_index'],'data='.$R['uid'].' and list='.$_R['uid'])  ?>
                  <div class="d-flex justify-content-between align-items-center py-1">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="listRadio<?php echo $_R['uid'] ?>" name="postlist_members[]" value="<?php echo $_R['uid'] ?>" class="custom-control-input" <?php echo $is_list?' checked':'' ?>>
                      <label class="custom-control-label" for="listRadio<?php echo $_R['uid'] ?>"><?php echo $_R['name'] ?></label>
                    </div>
                    <i class="material-icons f18 text-muted mr-2" data-toggle="tooltip" title="<?php echo $g['displaySet']['label'][$_R['display']] ?>"><?php echo $g['displaySet']['icon'][$_R['display']] ?></i>
                  </div>
                  <?php endforeach?>

                  <?php if(!$NUM):?>
                  <div class="text-center text-muted p-5" data-role="none">리스트가 없습니다.</div>
                  <?php endif?>

                </div><!-- /.dropdown-body -->

                <div class="dropdown-footer px-2">
                  <button type="button" class="btn btn-white btn-block" data-role="list-add-button">+ 리스트 추가</button>
                  <div class="input-group d-none" data-role="list-add-input">
                    <input type="text" class="form-control" placeholder="리스트명 입력" name="list_name">
                    <div class="input-group-append">
                      <button class="btn btn-white" type="button" data-act="list-add-submit">
                        <span class="not-loading">
                          추가
                        </span>
                        <span class="is-loading">
                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                      </button>
                      <button class="btn btn-white" type="button" data-act="list-add-cancel">취소</button>
                    </div>
                  </div><!-- /.input-group -->
                </div><!-- /.dropdown-footer -->
              </div>
            </div>

          </div>

          <div class="form-group mb-3">
            <label class="small text-muted">포스트 URL</label>
            <div class="input-group" data-role="ref_selector">
              <div class="input-group-prepend">
                <button class="btn btn-white dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  선택
                </button>
                <div class="dropdown-menu shadow" data-url="<?php echo $g['url_root'].getPostLink($R,0) ?>">
                  <a class="dropdown-item" href="#" data-ref="kt">카카오톡</a>
                  <a class="dropdown-item" href="#" data-ref="yt">유튜브</a>
                  <a class="dropdown-item" href="#" data-ref="fb">페이스북</a>
                  <a class="dropdown-item" href="#" data-ref="ig">인스타그램</a>
                  <a class="dropdown-item" href="#" data-ref="nb">네이버 블로그</a>
                  <a class="dropdown-item" href="#" data-ref="ks">카카오스토리</a>
                  <a class="dropdown-item" href="#" data-ref="tt">트위터</a>
                  <div role="separator" class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-ref="em">이메일</a>
                  <a class="dropdown-item" href="#" data-ref="sm">SMS</a>
                  <a class="dropdown-item" href="#" data-ref="et">기타</a>
                </div>
              </div>
              <input type="text" class="form-control" value="<?php echo $g['url_root'].getPostLink($R,0) ?>" readonly id="_url_">
              <div class="input-group-append">
                <button type="button" class="btn btn-white js-clipboard js-tooltip" title="클립보드에 복사" data-clipboard-target="#_url_">
                  <i class="fa fa-clone" aria-hidden="true"></i>
                </button>
                <a class="btn btn-white" href="<?php echo getPostLink($R,0) ?>" target="_blank" data-toggle="tooltip" title="최종화면" data-role="landing">
                  <i class="fa fa-share" aria-hidden="true"></i>
                </a>
              </div>
            </div>
            <small class="form-text text-muted mt-2 pl-1">통계분석을 위해 외부공유시 매체별 전용URL 사용해주세요.</small>
          </div>

          <div class="form-group">
            <label class="small text-muted">컨텐츠 포맷</label>
            <select name="format" class="form-control custom-select meta">
              <?php $_formatset=explode(',',$d['theme']['format'])?>
              <?php $i=1;foreach($_formatset as $_format):?>
                <option value="<?php echo $i ?>" <?php if($i==$R['format']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_format?></option>
              <?php $i++;endforeach;?>
            </select>
          </div>

          <?php if ($R['mbruid']!=$my['uid']): ?>
          <div class="alert alert-info f12 py-2" role="alert">
            공유 포스트 입니다.
          </div>
          <?php endif; ?>

          <fieldset data-role="display" class="d-none"<?php echo $my['uid']!=$R['mbruid']?' disabled':'' ?>>
            <span class="d-block mt-2 small text-muted">공유 설정</span>
            <ul class="list-group list-group-flush f13 mt-1 border-bottom">
              <li class="list-group-item d-flex w-100 justify-content-between align-items-center px-0">

                <div class="media text-muted">
                  <i class="material-icons f28 ml-1 mr-3 align-self-center" data-role="icon"></i>
                  <div class="media-body align-self-center">
                    <span data-role="heading"></span> <br><span class="f12 text-muted" data-role="description"></span>
                  </div>
                </div>

                <div class="dropdown">
                  <button type="button" class="btn btn-link btn-sm text-nowrap" data-toggle="dropdown">
                    변경...
                  </button>

                  <div class="dropdown-menu dropdown-menu-right shadow py-0" style="width:322px;line-height: 1.2">

                    <div class="list-group list-group-flush">
                      <button type="button" class="list-group-item list-group-item-action<?php echo $R['display']==5?' active':'' ?>" data-icon="<?php echo $g['displaySet']['icon'][5] ?>" data-display="5">
                        <div class="media align-items-center">
                          <i class="material-icons mr-3 f28"><?php echo $g['displaySet']['icon'][5] ?></i>
                          <div class="media-body">
                            <span data-heading><?php echo $g['displaySet']['label'][5] ?></span><br>
                            <small data-description>모든 사용자가 검색하고 볼 수 있음</small>
                          </div>
                        </div>
                      </button>
                      <button type="button" class="list-group-item list-group-item-action<?php echo $R['display']==4?' active':'' ?>" data-icon="<?php echo $g['displaySet']['icon'][4] ?>" data-display="4">
                        <div class="media align-items-center">
                          <i class="material-icons mr-3 f28"><?php echo $g['displaySet']['icon'][4] ?></i>
                          <div class="media-body">
                            <span data-heading><?php echo $g['displaySet']['label'][4] ?></span><br>
                            <small data-description>사이트 회원만 볼수 있음. 로그인 필요</small>
                          </div>
                        </div>
                      </button>
                      <button type="button" class="list-group-item list-group-item-action<?php echo $R['display']==3?' active':'' ?>" data-icon="<?php echo $g['displaySet']['icon'][3] ?>" data-display="3">
                        <div class="media align-items-center">
                          <i class="material-icons mr-3 f28"><?php echo $g['displaySet']['icon'][3] ?></i>
                          <div class="media-body">
                            <span data-heading><?php echo $g['displaySet']['label'][3] ?></span><br>
                            <small data-description>링크 있는 사용자만 볼 수 있음. 로그인 불필요</small>
                          </div>
                        </div>
                      </button>
                      <button type="button" class="list-group-item list-group-item-action<?php echo $R['display']==2?' active':'' ?>" data-icon="<?php echo $g['displaySet']['icon'][2] ?>" data-display="2">
                        <div class="media align-items-center">
                          <i class="material-icons mr-3 f28"><?php echo $g['displaySet']['icon'][2] ?></i>
                          <div class="media-body">
                            <span data-heading><?php echo $g['displaySet']['label'][2] ?></span><br>
                            <small data-description>지정된 친구만 볼수 있음</small>
                          </div>
                        </div>
                      </button>
                      <button type="button" class="list-group-item list-group-item-action<?php echo $R['display']==1?' active':'' ?>" data-icon="<?php echo $g['displaySet']['icon'][1] ?>" data-display="1">
                        <div class="media align-items-center">
                          <i class="material-icons mr-3 f28"><?php echo $g['displaySet']['icon'][1] ?></i>
                          <div class="media-body">
                            <span data-heading><?php echo $g['displaySet']['label'][1] ?></span><br>
                            <small data-description>나만 볼수 있음</small>
                          </div>
                        </div>
                      </button>
                    </div>

                  </div>
                </div>

              </li>
            </ul>

            <div  data-role="postmember">
              <ul class="list-group list-group-flush f13 mt-1">

                <?php foreach($MBR_RCD as $MBR): ?>
                <li class="list-group-item d-flex w-100 justify-content-between align-items-center px-0">
                  <input type="hidden" name="postmembers[]" value="[<?php echo $MBR['memberuid'] ?>]">
                  <div class="media">
                    <img class="rounded ml-1 mr-2" src="<?php echo getAvatarSrc($MBR['memberuid'],'31') ?>" width="31" height="31" alt="<?php echo $MBR['name'] ?>">

                    <div class="media-body align-self-center">
                      <?php echo $MBR['nic'] ?>님 <?php echo $my['uid']==$MBR['memberuid']?'(나)':'' ?>
                      <br>
                      <span class="text-muted"><?php echo $MBR['email'] ?></span>
                    </div>
                  </div>

                  <div class="pr-3">
                    <span class="f12 text-muted">

                      <?php if ($MBR['memberuid']==$R['mbruid']): ?>
                      소유자
                      <?php else: ?>

                        <span class="badge badge-pill badge-light"><?php echo $MBR['level']==1?'수정가능':'' ?></span>

                        <div class="dropdown d-inline-block align-middle ">
                          <button class="btn btn-link text-reset" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item<?php echo $MBR['level']==1?' active':'' ?>" href="#">
                              <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                              수정 가능
                            </a>
                            <a class="dropdown-item<?php echo !$MBR['level']?' active':'' ?>" href="#">
                              <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                              보기 가능
                            </a>
                            <?php if ($MBR['memberuid']!=$R['mbruid']): ?>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" type="button" data-act="delete" data-mbruid="<?php echo $MBR['memberuid'] ?>" data-post="<?php echo $R['uid'] ?>">
                              제외
                            </button>
                            <?php endif; ?>
                          </div>
                        </div>

                      <?php endif; ?>

                    </span>
                  </div>

                </li>
                <?php endforeach?>

              </ul>

              <div class="text-right mt-2">
                <button type="button" class="btn btn-white btn-sm" data-toggle="modal" data-target="#modal-post-share" data-backdrop="static">
                  친구 지정
                </button>
              </div>
            </div><!-- /data-role="postmember" -->

          </fieldset><!-- /data-role="display" -->


          <section class="mt-4 mb-2">
            <ul class="list-group list-group-horizontal text-center text-muted">
              <li class="list-group-item flex-fill py-2">
                <small>조회</small>
                <span class="d-block h3 mb-0">
                  <?php echo number_format($R['hit']) ?>
                </span>
              </li>
              <li class="list-group-item flex-fill py-2">
                <small>좋아요</small>
                <span class="d-block h3 mb-0">
                  <?php echo number_format($R['likes']) ?>
                </span>
              </li>
              <li class="list-group-item flex-fill py-2">
                <small>싫어요</small>
                <span class="d-block h3 mb-0">
                  <?php echo number_format($R['dislikes']) ?>
                </span>
              </li>
              <li class="list-group-item flex-fill py-2">
                <small>댓글</small>
                <span class="d-block h3 mb-0">
                  <?php echo number_format($R['comment']) ?>
                </span>
              </li>
            </ul>
          </section>

          <?php endif; ?>

        </div>
        <div class="tab-pane fade" id="attach" role="tabpanel" aria-labelledby="attach-tab">

          <div class="form-group mt-4 mb-5">
            <label class="sr-only">첨부파일</label>
            <?php include $g['dir_module_skin'].'_uploader.php'?>
          </div>

        </div>
        <div class="tab-pane" id="advan" role="tabpanel" aria-labelledby="link-tab">

          <ul class="list-group mb-4 text-muted" data-role="advanopt">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>댓글 사용</span>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="use_comment" value="1" id="use_comment"<?php echo $R['dis_comment']?'':' checked' ?>>
                <label class="custom-control-label" for="use_comment"></label>
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>좋아요 사용</span>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="use_like" value="1" id="use_like"<?php echo $R['dis_like']?'':' checked' ?>>
                <label class="custom-control-label" for="use_like"></label>
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>저장 허용</span>
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="use_listadd" value="1" id="use_listadd"<?php echo $R['dis_listadd']?'':' checked' ?>>
                <label class="custom-control-label" for="use_listadd"></label>
              </div>
            </li>
            <div class="d-none">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>평점 사용</span>
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" name="use_rating" value="1" id="use_rating"<?php echo $R['dis_rating']?'':' checked' ?>>
                  <label class="custom-control-label" for="use_rating"></label>
                </div>
              </li>
            </div>
          </ul>

          <?php if (getDbRows($table[$m.'category'],'site='.$s.' and reject=0 and hidden=0') && $d['post']['categoryperm']): ?>
          <strong class="d-block small text-muted pb-2">카테고리</strong>
          <div class="card mb-2 border-0 border-top" style="margin-left: -1rem;margin-right: -1rem">
            <div class="card-body pt-2 pb-0">
              <?php $_treeOptions=array('site'=>$s,'table'=>$table[$m.'category'],'dispNum'=>true,'dispHidden'=>false,'dispCheckbox'=>true,'allOpen'=>true)?>
              <?php echo getTreePostCategoryCheck($_treeOptions,$R['uid'],0,0,'')?>
            </div>
          </div>
          <?php endif; ?>

          <?php if ($cid): ?>
          <section class="mt-4">
            <div class="d-flex justify-content-between">
              <label class="small text-muted">수정이력</label>
              <a href="#modal-post-log" class="muted-link small mr-3" data-toggle="modal" data-backdrop="static">
                더보기
              </a>
            </div>

            <table class="table table-sm table-bordered f13 text-muted text-center">
              <tbody>
                <tr>
                  <th scope="row">최초 작성</th>
                  <td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
                </tr>
                <?php if ($R['d_modify']): ?>
                <tr>
                  <th scope="row">마지막 수정</th>
                  <td><?php echo getDateFormat($R['d_modify'],'Y.m.d H:i')?></td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>

          </section>

          <?php if ($R['mbruid']==$my['uid']): ?>
          <a class="btn btn-block btn btn-outline-danger my-4" href="<?php echo $g['post_delete'].$R['cid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?');">
            포스트 삭제
          </a>
          <?php endif; ?>

          <?php endif; ?>

        </div>
        <div class="tab-pane" id="link" role="tabpanel" aria-labelledby="link-tab">

          <?php getWidget('_default/attach',array('parent_module'=>'post','theme'=>'_desktop/bs4-default-link','attach_handler_photo'=>'[data-role="attach-handler-photo"]','parent_data'=>$R,'wysiwyg'=>'Y'));?>

        </div>

        <?php if ($d['post']['goodsperm']): ?>
        <div class="tab-pane" id="goods" role="tabpanel" aria-labelledby="goods-tab">

          <div class="form-group">
            <label class="small text-muted">상품연결 </label>
            <div class="input-group">
              <input type="text" class="form-control meta" placeholder="상품명 검색" data-plugin="autocomplete">
            </div>
            <small class="form-text text-muted"></small>
          </div>

          <div class="dd" id="nestable-goods">
            <ol class="list-group bg-faded dd-list" data-role="attach-goods"></ol>
          </div>

        </div><!-- /.tab-pane -->
        <?php endif; ?>

      </div>
    </div>
  </aside><!-- /.col -->

  <div class="position-absolute" style="top:15px;right:30px">

    <?php if (!$cid): ?>
    <button type="button" class="btn btn-link" data-history="back">취소</button>
    <?php else: ?>

    <span class="mr-2 f13 align-middle font-italic d-inline-block animated fadeIn delay-1" data-toggle="tooltip" title="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'Y.m.d H:i')?>" data-role="d_modify">
      <time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time>
      저장 되었습니다.
    </span>

    <a class="btn btn-white" href="<?php echo RW('mod=dashboard&page=post')?>" data-role="library">포스트 관리</a>

    <?php endif; ?>

    <button type="button" class="btn btn-primary<?php echo $cid?' d-none':'' ?>" data-role="postsubmit" data-toggle="tooltip" title="단축키 (ctl+m)">
      <span class="not-loading">
        저장하기
      </span>
      <span class="is-loading">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        저장중
      </span>
    </button>

    <div class="d-inline-block dropdown">
      <a class="d-block ml-3" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-role="tooltip" title="프로필보기 및 회원계정관리">
        <img src="<?php echo getAvatarSrc($my['uid'],'30') ?>" width="30" height="30" alt="" class="rounded-circle">
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <h6 class="dropdown-header"><?php echo $my['nic'] ?> 님</h6>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo RW('m=post&mod=write')?>">
          새 포스트
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo RW('mod=dashboard')?>">
          대시보드
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo getProfileLink($my['uid'])?>">
          프로필
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo RW('mod=settings')?>">
          설정
        </a>
        <button class="dropdown-item" type="button" data-act="logout" role="button">
          로그아웃
        </button>
        <?php if ($my['admin']): ?>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="/admin" target="_top">관리자모드</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

</form>

<!-- Modal: 공유 사용자 초대 -->
<div class="modal" id="modal-post-share" tabindex="-1" role="dialog" aria-hidden="true">
  <input type="hidden" name="data" value="<?php echo $R['uid']?>">
  <input type="hidden" name="level" value="1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title">공유 설정</h5>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <label class="small text-muted">초대할 사용자</label>
          <div class="input-group input-group-lg">
            <input type="text" name="nic" class="form-control rounded-0" placeholder="닉네임 입력">
            <div class="input-group-append">
              <button class="btn btn-white dropdown-toggle rounded-0" data-toggle="dropdown" type="button">
                <i class="fa fa-eye" aria-hidden="true"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#" data-level="1">
                  <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                  수정가능
                </a>
                <a class="dropdown-item active" href="#" data-level="0">
                  <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                  보기가능
                </a>
              </div>
            </div>
          </div>

        </div>


      </div>
      <div class="modal-footer border-top-0">
        <button type="button" class="btn btn-light" data-dismiss="modal">취소</button>
        <button type="button" class="btn btn-primary" data-act="submit">
          <span class="not-loading">저장</span>
          <span class="is-loading">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          </span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- modal : 포스트 수정이력 -->
<div class="modal" tabindex="-1" role="dialog" id="modal-post-log">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">수정이력</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="">
        <table class="table text-center text-muted mb-0">
          <thead>
            <tr>
              <th scope="col">수정자</th>
              <th scope="col">수정일시</th>
            </tr>
          </thead>
          <tbody>
          <?php $array = explode('<s>',$R['log']); ?>
          <?php foreach ($array as $val): ?>
          <?php
          if ($val=='') continue;
          $valx = explode('|',$val);
          ?>
          <tr>
            <td><?php echo $valx[0] ?></td>
            <td><?php echo $valx[1] ?></td>
          <tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php getImport('smooth-scroll','smooth-scroll.min','16.1.0','js') ?>

<!-- 클립보드저장 : clipboard.js  : https://github.com/zenorocha/clipboard.js-->
<?php getImport('clipboard','clipboard.min','2.0.4','js') ?>

<!-- jQuery-Autocomplete : https://github.com/devbridge/jQuery-Autocomplete -->
<?php getImport('jQuery-Autocomplete','jquery.autocomplete.min','1.3.0','js') ?>

<script>

// 내용 변경 감지
var content = editor.getData();
var changed_meta = false;  //부가정보 수정여부
var changed_content =  false;  // 본문수정 여부
var checkUnload = false;  // 페이지 이탈시 경고창 출력여부 (기본값 : 출력안함)

putCookieAlert('post_action_result') // 실행결과 알림 메시지 출력

function setPostDisplay(display) {
  var section = $('[data-role="display"]');
  var button = section.find('.list-group-item[data-display="'+display+'"]')
  var input = $('[name="display"]');
  var icon = button.attr('data-icon');
  var heading = button.find('[data-heading]').text();
  var description = button.find('[data-description]').html();

  section.find('.list-group-item').removeClass('active'); // 상태초기화
  section.find('[data-role="postmember"]').removeClass('d-none');

  button.addClass('active');
  input.val(display);
  section.find('[data-role="icon"]').text(icon);
  section.find('[data-role="heading"]').text(heading);
  section.find('[data-role="description"]').html(description);
  section.removeClass('d-none')
  if (display==1) section.find('[data-role="postmember"]').addClass('d-none');
}

$(document).ready(function() {

  var clipboard = new ClipboardJS('.js-clipboard');

  clipboard.on('success', function (e) {
    $(e.trigger)
      .attr('title', '복사완료!')
      .tooltip('_fixTitle')
      .tooltip('show')
      .attr('title', '클립보드 복사')
      .tooltip('_fixTitle')

    e.clearSelection()
  })

  // smoothScroll : https://github.com/cferdinandi/smooth-scroll
  var scroll_content = new SmoothScroll('[data-toggle="toc"] a[href*="#"]',{
  	ignore: '[data-scroll-ignore]'
  });

  //$("#toc").empty();
  listCheckedNum()
  //doToc();

  // dropdown 내부클릭시 dropdown 유지
	$('[data-role="list-selector"] .dropdown-menu').on('click', function(e) {
		e.stopPropagation();
	});

  $('[data-role="list-add-button"]').click( function() {
    $(this).addClass('d-none');
    $('[data-role="list-add-input"]').removeClass('d-none')
    $('[data-role="list-add-input"]').find('.form-control').val('').focus();
  } );
  $('[data-act="list-add-cancel"]').click( function() {
    $('[data-role="list-add-button"]').removeClass('d-none');
    $('[data-role="list-add-input"]').addClass('d-none')
  } );

  $(document).on('change','[data-role="list-selector"] [type="checkbox"]',function(){
    listCheckedNum()
  });

  $('.rb-post-write').find('.meta.form-control, .form-check-input,[data-role="advanopt"] .custom-control-input').change(function(){
    showSaveButton(true); // 저장버튼 출력
    $('[data-role="postsubmit"]').click(); // 저장
  });

  editor.model.document.on( 'change:data', () => {
    if (content!=editor.getData()) {
      showSaveButton(true); // 저장버튼 출력
      checkUnload = true; //페이지 이탈시 경고창 출력
    } else {
      showSaveButton(false); // 저장버튼 숨김
      checkUnload = false; //페이지 이탈시 경고창 미출력
    }
  });

  $(window).on("beforeunload", function(){
      if(checkUnload) return "이 페이지를 벗어나면 작성된 내용은 저장되지 않습니다.";
  });

  $('[data-role="postsubmit"]').click(function(){
    checkUnload = false; //페이지 이탈시 경고창 미출력
    $('[data-toggle="tooltip"]').tooltip('hide');
    savePost(document.writeForm)
  });

  $('[data-role="list-selector"]').on('hidden.bs.dropdown', function () {
    showSaveButton(true); // 저장버튼 출력
    checkUnload = true; //페이지 이탈시 경고창 출력
  })

  $('[data-act="list-add-submit"]').click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var button = $(this)
    var input = $('[name="list_name"]');
    var list = $('[data-role="list-selector"]');
    var checked_num = list.find('[data-role="list_num"]');
    var checked_num_val = Number(checked_num.text());
    var name = input.val();

    if (!name) {
      input.focus();
      return false
    }
    button.attr( 'disabled', true );

    setTimeout(function(){

      $.post(rooturl+'/?r='+raccount+'&m=post&a=regis_list',{
        name : name,
        send_mod : 'ajax'
        },function(response,status){
          if(status=='success'){
            var result = $.parseJSON(response);
            var uid=result.uid;
            var icon=result.icon;
            var label=result.label;
            var item = '<div class="d-flex justify-content-between align-items-center py-1"><div class="custom-control custom-checkbox">'+
                          '<input type="checkbox" id="listRadio'+uid+'" name="postlist_members[]" value="'+uid+'" class="custom-control-input" checked>'+
                          '<label class="custom-control-label" for="listRadio'+uid+'">'+name+'</label>'+
                        '</div><i class="material-icons f18 text-muted mr-2" data-toggle="tooltip" title="" data-original-title="'+label+'">'+icon+'</i></div>';
            button.attr( 'disabled', false );
            input.val('');
            list.find('[data-role="none"]').addClass('d-none');
            list.find('[data-role="list-add-button"]').removeClass('d-none');
            list.find('[data-role="list-add-input"]').addClass('d-none')
            list.find('.dropdown-body').append(item);
            checked_num.text(checked_num_val+1);
            list.find('[data-toggle="tooltip"]').tooltip();
          } else {
            alert(status);
          }
      });
    }, 200);
  });

  setPostDisplay(<?php echo $R['display'] ?>) // 현재 공개상태 셋팅

  $('[data-role="display"] .dropdown-menu .list-group-item').click(function(){
    var button = $(this)
    var display = button.attr('data-display');
    setPostDisplay(display) // 공개상태 변경
    showSaveButton(true); // 저장버튼 출력
    $('[data-role="postsubmit"]').click(); // 저장
  });

  // 퀵메뉴 단축키 지원
  $(document).on('keydown', function ( e ) {
    if ((e.metaKey || e.ctrlKey) && ( String.fromCharCode(e.which).toLowerCase() === 'm') ) {
      $('[data-role="postsubmit"]').removeClass('d-none');
      $('[data-role="library"]').addClass('d-none');
      $('[data-role="postsubmit"]').click(); // 저장
    }
  });

  //사용자 초대
  $('#modal-post-share').on('shown.bs.modal', function () {
    $(this).find('[name="nic"]').trigger('focus')
    $(this).find('[data-act="submit"]').attr('disabled', false);
  })

  $('#modal-post-share').find('[data-act="submit"]').click(function(e){
    var button = $(this);
    var modal = $('#modal-post-share');

    var data = modal.find('[name="data"]').val();
    var level = modal.find('[name="level"]').val();
    var nic = modal.find('[name="nic"]').val();

    if (!nic) {
      modal.find('[name="nic"]').focus();
      return false
    }

    button.attr('disabled',true);

    setTimeout(function(){

      $.post(rooturl+'/?r='+raccount+'&m=post&a=regis_member',{
        data : data,
        level : level,
        nic : nic
        },function(response,status){
          if(status=='success'){
            var result = $.parseJSON(response);
            var mbruid=result.mbruid;
            var html = '<input type="hidden" name="postmembers[]" value="['+mbruid+']">';
            $('#modal-post-share').modal('hide');
            $('[data-role="postmember"]').append(html);
            showSaveButton(true); // 저장버튼 출력
            $('[data-role="postsubmit"]').click(); // 저장
            setTimeout(function(){ location.reload(); }, 400);
          } else {
            alert(status);
          }
      });
    }, 200);
  });

  // 공유목록에서 제외
  $('[data-role="postmember"]').find('[data-act="delete"]').click(function(e){

    if (confirm('정말로 공유목록에서 제외 하시겠습니까?')) {

      var button = $(this);
      var list = $('[data-role="postmember"]');
      var item = button.closest('.list-group-item');
      var data = button.attr('data-post');
      var mbruid = button.attr('data-mbruid');

      setTimeout(function(){

        $.post(rooturl+'/?r='+raccount+'&m=post&a=deletemember',{
          data : data,
          mbruid : mbruid
          },function(response,status){
            if(status=='success'){
              // var result = $.parseJSON(response);
              item.remove();
              showSaveButton(true); // 저장버튼 출력
              $('[data-role="postsubmit"]').click(); // 저장
            } else {
              alert(status);
            }
        });
      }, 200);

		}
		return false;

  });

  $('[data-role="ref_selector"]').find('.dropdown-item').click(function(){
    var item = $(this)
    var selector = $('[data-role="ref_selector"]')
    var ref = item.attr('data-ref');
    var url = selector.find('.dropdown-menu').attr('data-url');
    var label = item.text();
    selector.find('[data-toggle="dropdown"]').text(label)
    selector.find('[type="text"]').val(url+'?ref='+ref)
    selector.find('.js-tooltip').click();
  });

  $('#quick-write').find('button').click(function(){
    var fieldset = $('#quick-write');
    var button = $(this)
    var textarea =  fieldset.find('textarea');
    var url = textarea.val();
    if (!url) {
      textarea.focus();
      return false;
    }

    var link_url_parse = $('<a>', {href: url});

    //네이버 블로그 URL의 실제 URL 변환
    if ((link_url_parse.prop('hostname')=='blog.naver.com' || link_url_parse.prop('hostname')=='m.blog.naver.com' ) && link_url_parse.prop('pathname')) {
      var nblog_path_arr = link_url_parse.prop('pathname').split("/");
      var nblog_id = nblog_path_arr[1];
      var nblog_pid = nblog_path_arr[2];
      if (nblog_pid) {
        var url =  'https://blog.naver.com/PostView.nhn?blogId='+nblog_id+'&logNo='+nblog_pid;
      } else {
        var url = 'https://blog.naver.com/PostList.nhn?blogId='+nblog_id;
      }
    }

    button.attr('disabled',true);
    textarea.attr('disabled',true)

    $.get('//embed.kimsq.com/oembed',{
  			url: url
  	}).done(function(response) {
        var type = response.type;
  			var title = response.title;
        var description = response.description?response.description:'.';
        var description = linkifyStr(description,{ target: '_blank' });
        var description = description.replace(/(?:\r\n|\r|\n)/g, '<br>');
        var thumbnail_url = response.thumbnail_url;
        var author = response.author;
        var provider = response.provider_name;
        var url = response.url;
        var width = response.thumbnail_width;
        var height = response.thumbnail_height;
        var embed = response.html;
  			$('[name="subject"]').val(title);

        const viewFragment = editor.data.processor.toView( description );
        const modelFragment = editor.data.toModel( viewFragment );

        editor.model.insertContent( modelFragment );

        if (type=='video') {

          $.get('//embed.kimsq.com/iframely',{
        			url: url
        	}).done(function(response) {
              var duration = response.meta.duration;
              var _duration = moment.duration(duration, 's');
              var formatted_duration = _duration.format("h:*m:ss");

              $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=saveLink',{
                 type : 9,
                 title : title,
                 theme : '_desktop/bs4-default-link',
                 description : description,
                 thumbnail_url : thumbnail_url,
                 author: author,
                 provider : provider,
                 url : url,
                 duration : duration?duration:'',
                 time :  duration?formatted_duration:'',
                 width : width,
                 height : height,
                 embed : embed
              },function(response){
                  var result=$.parseJSON(response);
                  var uid = result.last_uid
                  if(!result.error){
                    fieldset.find('[name="attachfiles[]"]').val(uid);
                    fieldset.find('[name="format"]').val(2);  //비디오 타입
                    $('[name="featured_img"]').val(uid);
                    $('[data-role="postsubmit"]').click(); // 포스트 저장
                  }
              });

        	});

        } else {

          $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=saveLink',{
            type : 8,
            title : title,
            saveDir : '<?php echo $g['path_file']?>post/',
            theme : '_desktop/bs4-default-link',
            description : description,
            thumbnail_url : thumbnail_url,
            author: author,
            provider : provider,
            url : url,
            width : width,
            height : height,
            embed : embed
          },function(response){
            var result=$.parseJSON(response);
            var uid = result.last_uid
            if(!result.error){

              const content = '<figure class="media"><oembed url="'+url+'"></oembed></figure>';
              const viewFragment = editor.data.processor.toView( content );
              const modelFragment = editor.data.toModel( viewFragment );
              editor.model.insertContent( modelFragment );

              fieldset.find('[name="attachfiles[]"]').val(uid);
              fieldset.find('[name="format"]').val(1);  //문서 타입
              $('[name="featured_img"]').val(uid);
              $('[data-role="postsubmit"]').click(); // 포스트 저장
            }
          });
        }

  	}).fail(function() {
      alert( "URL을 확인해주세요." );
      button.attr('disabled',false);
      textarea.attr('disabled',false).focus()
    }).always(function() {
    });

  });


  // 첨부상품 순서변경
  $('#nestable-goods').nestable({
    group: 1,
    maxDepth: 1
  });

  // 순서변경 내역 저장
  $('#nestable-goods').on('change', function() {
    var attachGoods=$('input[name="attachGoods[]"]').map(function(){return $(this).val()}).get();
    var new_goods='';
    if(attachGoods){
      for(var i=0;i<attachGoods.length;i++) {
        new_goods+=attachGoods[i];
      }
    }

    showSaveButton(true); // 저장버튼 출력
    $('[data-role="postsubmit"]').click(); // 저장

    console.log('첨부상품 순서저장');
    return false

    $.post(rooturl+'/?r='+raccount+'&m=post&a=modifygid',{
       attachGoods : new_goods
     });
  });

  //상품연결을 위한 상품명 검색
  $('[data-plugin="autocomplete"]').autocomplete({
    width : 320,
    minChars:1,
    showNoSuggestionNotice: true,
    noSuggestionNotice : '결과가 없습니다.',
    lookup: function (query, done) {

       $.getJSON(rooturl+"/?m=shop&a=search_data", {q: query,featured_size : '70x52'}, function(res){
           if (res.goodslist) {
             var sg_goods = [];
             var data_arr = res.goodslist.split(',');//console.log(data.usernames);
             $.each(data_arr,function(key,goods){
               var goodsData = goods.split('|');
               var name = goodsData[0];
               var uid = goodsData[1];
               var featured_img = goodsData[2];
               var price = goodsData[3];
               sg_goods.push({"value":name,"data":{ 'uid': uid, 'featured_img': featured_img, 'price': price }});
             });
             var result = {
               suggestions: sg_goods
             };
              done(result);
           }
       });
   },

   formatResult: function (suggestion,currentValue) {
     return '<div class="media"><img src="' + suggestion.data.featured_img+'" class="border mr-2" /><div class="media-body">'  + $.Autocomplete.formatResult(suggestion, currentValue) + '<br><small class="text-muted  ">'+ suggestion.data.price+'</small></div></div>';
    },

    onSelect: function (suggestion) {
      if ($('[data-plugin="autocomplete"]').val().length >= 1) {
        console.log(suggestion.data.uid)
        $(this).val('');

        $.post(rooturl+'/?r='+raccount+'&m=shop&a=get_goodsData',{
            markup_file: 'attach_goods_write_item',
            uid : suggestion.data.uid,
            featured_size : '70x52'
          },function(response){
           var result = $.parseJSON(response);
           var item=result.item;
           $('[data-role="attach-goods"]').append(item);
           showSaveButton(true); // 저장버튼 출력
           $('[data-role="postsubmit"]').click(); // 저장
        });

      }
    }
  });

  //연결된 상품 불러기
  // $.post(rooturl+'/?r='+raccount+'&m=shop&a=get_postAttachGoods',{
  //   markup_file: 'attach_goods_write_item',
  //   uid : <?php echo $R['uid'] ?>,
  //   featured_size : '70x52'
  //   },function(response,status){
  //     if(status=='success'){
  //       var result = $.parseJSON(response);
  //       var list=result.list;
  //       $('[data-role="attach-goods"]').html(list);
  //     } else {
  //       alert(status);
  //     }
  // });

  //연결상품 지우기
  $('[data-role="attach-goods"]').on('click','[data-act="del"]',function(){
    var item = $(this).closest('[data-role="item"]')
    item.remove();
    showSaveButton(true); // 저장버튼 출력
    $('[data-role="postsubmit"]').click(); // 저장
  });



});

</script>
