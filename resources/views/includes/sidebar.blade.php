<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="../../dist/img/{{ Auth::user()->email }}.jpg" class="img-circle" alt="User Image" onerror="this.onerror=null; this.src='../../dist/img/default.png'">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header" style="white;">MAIN NAVIGATION</li>
      <!-- {{-- Customer Order --}} -->
      <?php
        $special_user = (
          in_array(
            Auth::user()->email,
            array(
              'ebmulyono@gmail.com',
              'ppc@mahsing.co.id',
              'whse2@mahsing.co.id',
              'almaidi@whs-portal.internal',
              'sugihatin@whs-portal.internal',
              'it@mahsing.co.id',
              'it3@mahsing.co.id',
              'it4@mahsing.co.id',
              'it6@mahsing.co.id',
              'darmin@whs-portal.internal',
              'darmin@whs-portal.intranet',
              'ekow@mahsing.internal',
              'ekow@whs-portal.intranet',
              'ekow@whs-portal.internal',
            )
          )
        ) ? TRUE : FALSE;
        if(isset($filename)){
          $req = 'orderadm/'.$filename;
          $reqDenso = 'orderDenso/'.$filename;
          $reqNHK = 'orderNHK/'.$filename;
          $reqKRM = 'orderKRM/'.$filename;
          $reqtmmin = 'ordertmmin/'.$filename;
          $reqiami = 'iami/order/' . $filename;
          $sendiamiorder = 'iami/detailorder/' . $filename;
          $reqlainlain = 'orderlainlain/'.$filename;
        } else {
          $req = 'orderadm';
          $reqDenso = 'orderDenso';
          $reqNHK = 'orderNHK';
          $reqKRM = 'orderKRM';
          $reqtmmin = 'ordertmmin';
          $reqiami = 'iami/order';
          $sendiamiorder = 'iami/detailorder';
          $reqlainlain = 'orderlainlain';
        }
        if(isset($id)){
          $sendabas = 'sendadm/'.$id;
          $sendDenso = 'sendDenso/'.$id;
          $printNHK = 'printlabelNHK/'.$id;
          $labelKRM = 'labelKRM/'.$id;
          $sendtmmin = 'sendtmmin/'.$id;
          $reqiami = 'iami/order/' . $id;
          $sendiami = 'iami/sendorder/' . $id;
          $labellainlain = 'labellainlain/'.$id;
        } else {
          $sendabas = 'sendadm';
          $sendDenso = 'sendDenso';
          $printNHK = 'printlabelNHK';
          $labelKRM = 'labelKRM';
          $sendtmmin = 'sendtmmin';
          $reqiami = 'iami/order';
          $sendiami = 'iami/sendorder';
          $labellainlain = 'labellainlain';
        }
        if(isset($monitor)){
          if(isset($list)){
            $monitorADM = 'monitoradm/list/'.$monitor;
            $monitorDenso = 'monitorDenso/list/'.$monitor;
            $monitorNHK = 'monitorNHK/list/'.$monitor;
            $monitorKRM = 'monitorKRM/list/'.$monitor;
            $monitortmmin = 'monitortmmin/list/'.$monitor;
            $monitoriami = 'iami/monitor/list/' . $monitor;
            $monitorlainlain = 'monitorlainlain/list/'.$monitor;
          } else {
            $monitorADM = 'monitoradm/'.$monitor;
            $monitorDenso = 'monitorDenso/'.$monitor;
            $monitorNHK = 'monitorNHK/'.$monitor;
            $monitorKRM = 'monitorKRM/'.$monitor;
            $monitortmmin = 'monitortmmin/'.$monitor;
            $monitoriami = 'iami/monitor/' . $monitor;
            $monitorlainlain = 'monitorlainlain/'.$monitor;
          }
        } else {
          $monitorADM = 'monitoradm';
          $monitorDenso = 'monitorDenso';
          $monitorNHK = 'monitorNHK';
          $monitorKRM = 'monitorKRM';
          $monitortmmin = 'monitortmmin';
          $monitoriami = 'iami/monitor';
          $monitorlainlain = 'monitorlainlain';
        }
        if (isset($dn_number)) {
          $dn_NHK = 'dnNHK/'.$dn_number;
        }else{
          $dn_NHK = 'dnNHK';
        }
      ?>
    
      <li class="treeview @if(
            in_array(
              url()->current(),
              array(
                url($req), url($sendabas), url($monitorADM),
                url($reqDenso), url($sendDenso), url($monitorDenso), url('cleardoDenso'),
                url($reqKRM), url($labelKRM), url($monitorKRM), url('cleardoKRM'),
                url($reqNHK), url($printNHK), url($monitorNHK), url($dn_NHK), url('cleardoNHK'),
                url($reqtmmin), url($sendtmmin), url($monitortmmin), url('cleardotmmin'),
                url($reqiami), url($sendiamiorder), url($sendiami), url($monitoriami), url('cleardoiami'),
                url($reqlainlain), url($labellainlain), url($monitorlainlain), url('cleardolainlain'),
              )
            ) ||
            in_array(request()->segment(1), ['adm', 'tmmin'])
        ) active menu-open @endif">
        <a href="#">
          <i class="fa fa-shopping-cart"></i><span>Customer Data</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <!-- IAMI -->
          <li class="treeview @if (Request::is($reqiami) or Request::is($sendiamiorder) or Request::is($sendiami) or Request::is($monitoriami) or Request::is('cleardoiami')) active menu-open @endif">
              <a href="#">
                  <i class="fa fa-circle-o"></i><span>IAMI Order</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                  <li {{ Request::is($reqiami) ? 'class=active' : '' }}><a
                          href="{{ route('iami.order') }}/"><i class="fa fa-circle-o"></i>List
                          Order</a></li>
                
                  <li {{ Request::is($sendiami) ? 'class=active' : '' }}><a
                          href="{{ route('iami.sendorder') }}/"><i class="fa fa-circle-o"></i>Send
                          Order</a></li>
                  <li {{ Request::is($monitoriami) ? 'class=active' : '' }}><a
                          href="{{ route('iami.monitor') }}/"><i class="fa fa-circle-o"></i>Monitor
                          Delivery</a></li>
                  {{-- @if ($special_user)
                    <li class="@if (Request::is('cleardoiami')) active @endif"><a href="{{ route('iami.cleardo') }}/"><i class="fa fa-circle-o"></i>Clear Delivery Order</a></li>
                  @endif --}}
                  <li
                      class="treeview {{ request()->segment(1) == 'tmmin' && request()->segment(2) == 'delivery_note' ? 'active menu-open' : null }}">

                  </li>
              </ul>
          </li>
          <!--end IAMI-->
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
