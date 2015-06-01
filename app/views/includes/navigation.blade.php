
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ URL::to('/') }}"> AGRITECH (béta)</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-comment fa-fw"></i> 1 Nouvelle alerte
                            <span class="pull-right text-muted small">4 minutes environ</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-twitter fa-fw"></i> 3 Nouveaux agriculteurs
                            <span class="pull-right text-muted small">12 minutes environ</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-envelope fa-fw"></i> Nouvelle recolte
                            <span class="pull-right text-muted small">4 minutes environ</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-tasks fa-fw"></i> Nouvelle négociation
                            <span class="pull-right text-muted small">4 minutes environ</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-upload fa-fw"></i> Serveur redemarrer
                            <span class="pull-right text-muted small">4 minutes environ</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>Voir toutes les alertes</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> {{ Auth::user()->Username }} <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> Profile utilisateur</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{ URL::to('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Déconnection</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
        <li >
            <img alt="Brand" src="{{ URL::to('/') }}/assets/images/agritech-logo.png" style="height:35px;width:35px;" >
            
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a @if(Request::is('/')) class="active" @endif href="{{ URL::to('') }}"><i class="fa fa-dashboard fa-fw"></i> Tableau de bord</a>
                </li>
                @if(Auth::user()->hasRole('ALERT'))
                <li @if(Request::is('alerte') or Request::is('alerte/create') or Request::is('alerte/*/edit')) class="active" @endif>
                    <a href="#"><i class="fa fa-exclamation-triangle fa-fw"></i> Alertes<sspan class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a @if(Request::is('alerte') or Request::is('alerte/*/edit')) class="active" @endif href="{{ URL::to('alerte') }}"><i class="fa fa-list fa-fw"></i> Liste des alertes enregistrées</a>
                        </li>
                        <li>
                            <a @if(Request::is('alerte/create')) class="active" @endif href="{{ URL::to('alerte/create') }}"><i class="fa fa-plus fa-fw"></i> Ajouter une alerte</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                @endif
                @if(Auth::user()->hasRole('RECOLTE'))
                <li @if(Request::is('recolte') or Request::is('recolte/create') or Request::is('recolte/*/edit')) class="active" @endif>
                    <a href="#"><i class="fa fa-compass fa-fw"></i> Productions<sspan class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a @if(Request::is('recolte') or Request::is('recolte/*/edit')) class="active" @endif href="{{ URL::to('recolte') }}"><i class="fa fa-list fa-fw"></i> Liste des productions enregistrées</a>
                        </li>
                        <li>
                            <a @if(Request::is('recolte/create')) class="active" @endif href="{{ URL::to('recolte/create') }}"><i class="fa fa-plus fa-fw"></i> Ajouter une production</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                @endif
                @if(Auth::user()->hasRole('NEGOCIATIONRECOLTE'))
                <li @if(Request::is('negociationrecolte') or Request::is('negociationrecolte/*/create') or Request::is('recolte/*/edit/*')) class="active" @endif>
                    <a @if(Request::is('negociationrecolterecolte') or Request::is('negociationrecolte/*/edit/*') or Request::is('negociationrecolte/*/create')) class="active" @endif href="{{ URL::to('negociationrecolte') }}"><i class="fa fa-money fa-fw"></i> Négociations des productions </a>
                </li>
                @endif
                <!-- Zone de Culture -->
                <li @if(Request::is('cultures') or Request::is('culturezones') or Request::is('culture/*') or Request::is('culturezone/*')) class="active" @endif >
                    <a href="#"><i class="fa fa-sitemap fa-fw"></i> Zone de Culture<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a @if(Request::is('culturezones') or Request::is('culturezone/*')) class="active" @endif   href="{{ URL::to('culturezones') }}"><i class="fa fa-list fa-fw"></i> Liste des Zones</a>
                        </li>
                        <li>
                            <a  @if(Request::is('cultures') or Request::is('culture/*') ) class="active" @endif  href="{{ URL::to('cultures') }}"><i class="fa fa-list fa-fw"></i> Liste des Cultures</a>
                        </li>
                       
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
				<!-- End Zone de Culture -->
                @if(Auth::user()->hasRole('ADMIN'))
                <li @if(Request::is('admin/user') or Request::is('admin/user/create') or Request::is('admin/user/*/edit')) class="active" @endif>
                    <a href="#"><i class="fa fa-users fa-fw"></i> Utilisateurs<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a @if(Request::is('admin/user') or Request::is('admin/user/*/edit')) class="active" @endif href="{{ URL::to('admin/user') }}"><i class="fa fa-list fa-fw"></i> Liste des utilisateurs</a>
                        </li>
                        <li>
                            <a @if(Request::is('admin/user/create')) class="active" @endif href="{{ URL::to('admin/user/create') }}"><i class="fa fa-user-plus fa-fw"></i> Ajouter un utilisateur</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li @if(Request::is('admin/produit') or Request::is('admin/produit/create') or Request::is('admin/produit/*/edit')) class="active" @endif>
                    <a href="#"><i class="fa fa-tree fa-fw"></i> Produits<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a @if(Request::is('admin/produit') or Request::is('admin/produit/*/edit')) class="active" @endif href="{{ URL::to('admin/produit') }}"><i class="fa fa-list fa-fw"></i> Liste des produits</a>
                        </li>
                        <li>
                            <a @if(Request::is('admin/produit/create')) class="active" @endif href="{{ URL::to('admin/produit/create') }}"><i class="fa fa-plus fa-fw"></i> Ajouter un produit</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li @if(Request::is('admin/settings')) class="active" @endif>
                    <a @if(Request::is('admin/settings')) class="active" @endif href="{{ URL::to('admin/settings') }}"><i class="fa fa-wrench fa-fw"></i> Paramètres </a>
                </li>
                @endif
				
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>