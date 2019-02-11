<style>
section#_404_section{
    width:100%;
    height:100vh;
    background:#000;
    color:#fff;
    text-align:center;
    font-family:"Trebuchet MS";
    text-transform:uppercase;
    padding-top:2em;
    background: linear-gradient(
            to bottom,
            #000,
            #000 50%,
            #222 50%,
            #222
    );
    background-size: 100% 4px;
    animation: gradientMove 200ms ease infinite;
}
h1{ margin-top: 15%;
    margin-bottom:3%;
    font-size:6em;
    text-shadow: 3px 2px 2px rgba(251, 12, 12,1), 0px -1px 3px rgba(12, 79, 251,.5),-3px 0px 2px rgba(52, 251, 12, 1);
    animation: chromaticMove 4500ms ease infinite,pulse ease 200ms  infinite;
}
small{ display:block;
       text-transform:initial;
       font-size:24px;
}
@keyframes gradientMove {
    0%{background-size: 100% 4px}
    50%{background-size: 100% 2px}
    100%{background-size: 100% 4px}
}
@keyframes pulse {
    0%{ opacity:.9;transform: skewX(.5deg);}
    25%{ opacity:1;}
    50%{opacity:.9;}
    75%{ opacity:1; transform:skewX(.5deg);}
    100%{opacity:.9;}
}
@keyframes chromaticMove {
    0%{text-shadow: 3px 2px 2px rgba(251, 12, 12,1), 0px -1px 3px rgba(12, 79, 251,.5),0px 0px -2px rgba(52, 251, 12, 1);}
    50%{text-shadow: 3px 2px 2px rgba(251, 12, 12,1), 0px -1px 3px rgba(12, 79, 251,.5),-3px 2px 3px rgba(52, 251, 12, 1);}
    100%{text-shadow: 3px 2px 2px rgba(251, 12, 12,1), 0px -1px 3px rgba(12, 79, 251,.5),2px -1px 2px rgba(52, 251, 12, 1);}
}
</style>

<section id="_404_section">
    <h1>4 0 4<small> Page not found</small></h1>
    <a type="button" href="{{ route('home') }}" class="btn btn-info btn-lg">Back to HOME PAGE</a>
</section>

<!-- ____________________________________________________________________________________________________________________________ -->
<hr/>
<kbd> <?php printf('<b>Controller::Method --></b> %s', $show_controller_info);?> </kbd>
<!-- ____________________________________________________________________________________________________________________________ -->

