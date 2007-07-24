<?php
  require "camelot_funcs.php";
  require_once 'vrmlengine_functions.php';

  camelot_header("gen_funkcja", LANG_PL,
    "gen_funkcja - generator wykres�w funkcji dla glplottera.");
?>

<?php echo pretty_heading("gen_funkcja", VERSION_GEN_FUNKCJA); ?>

<p>Sk�adnia wywo�ania:
<pre>
  gen_funkcja &lt;funkcja&gt; &lt;x1&gt; &lt;x2&gt; &lt;xstep&gt;
</pre>

<p>W odpowiedzi gen_funkcja wypisze na standardowe wyj�cie wykres
funkcji <tt>&lt;funkcja&gt;</tt> na przedziale <tt>[&lt;x1&gt; ; &lt;x2&gt;]</tt>
(ze wsp�rz�dn� x pr�bkowan� co <tt>&lt;xstep&gt;</tt>) w formacie zrozumia�ym dla
<?php echo a_href_page("glplottera", "glplotter"); ?>.

<p>Oto program:
<?php echo_standard_program_download('gen_funkcja', 'gen_funkcja',
  VERSION_GEN_FUNKCJA, false); ?>

<p><?php echo SOURCES_OF_THIS_PROG_ARE_AVAIL; ?>

<h3>Dokumentacja:</h3>
<ol>
  <li><a href="#section_simple_example">Prosty przyk�ad</a>
  <li><a href="#section_function_expression">Specyfikacja zapisu funkcji</a>
</ol>

<p><a name="section_simple_example">Najpierw prosty przyk�ad.</a>
Polecenie

<pre>
  gen_funkcja "x^2" 0 5 1
</pre>

wypisuje w odpowiedzi

<pre>
# File generated by gen_funkcja on 14-3-2004 at 23:34:37
#   function = x^2
#   x1 = 0
#   x2 = 5
#   xstep = 1
name=x^2
 0.0000000000000000E+0000  0.0000000000000000E+0000
 1.0000000000000000E+0000  1.0000000000000000E+0000
 2.0000000000000000E+0000  4.0000000000000000E+0000
 3.0000000000000000E+0000  9.0000000000000000E+0000
 4.0000000000000000E+0000  1.6000000000000000E+0001
 5.0000000000000000E+0000  2.5000000000000000E+0001
</pre>

Linie zaczynaj�ce si� od znaku # (hash) to komentarze, b�d� zignorowane
przez program glplotter. Linia <tt>name=x^2</tt> b�dzie u�yta przez
glplottera do wy�wietlenia nazwy wykresu, ale poza tym jest bez znaczenia.
A nast�pne linie mo�naby zapisa� w bardziej czytelnej (ale r�wnowa�nej)
postaci jako:
<pre>
  0 0
  1 1
  2 4
  3 9
  4 16
  5 25
</pre>

Czyli lewa kolumna to po kolei liczby od 0 do 5 (co 1) a prawa kolumna
to warto�ci funkcji <tt>x^2</tt> (czyli x<sup>2</sup>) gdzie x to warto��
w lewej kolumnie.

<p>Polecenia
<pre>
  gen_funkcja "x^2" 0 5 1 > plik.plot
  glplotter plik.plot
</pre>

albo, kr�cej,

<pre>
  gen_funkcja "x^2" 0 5 1 | glplotter -
</pre>

wy�wietl� wi�c wykresik funkcji x<sup>2</sup> na przedziale <tt>[0;5]</tt>.

<h4><a name="section_function_expression">Specyfikacja zapisu funkcji</a></h4>

<p>Skr�t specyfikacji: to jest normalny zapis wyra�enia matematycznego
ze zmienn� x. Np. <tt>(x+4)*3+2</tt>, <tt>sin(x)</tt> itd.

<p><b>Czynnik</b> to
<ul>
  <li>Nazwa zmiennej (ci�g liter, podkre�le� i cyfr zaczynaj�cy si� liter�
    lub podkre�leniem).
    W przypadku <tt>gen_funkcja</tt> dozwolona jest tylko jedna nazwa
    zmiennej, <tt>x</tt>.
  <li>Sta�a: <tt>pi</tt>, <tt>enat</tt> lub liczba rzeczywista
    (np. <tt>3.14</tt>)
  <li>-czynnik (np. <tt>-x</tt>)
  <li>Wyra�enie w nawiasach (np. <tt>(12+34)</tt>).
  <li>Wywo�anie funkcji, np. <tt>sin(x)</tt> lub <tt>power(3.0, x)</tt>.
    Znane funkcje to
    <ul>
      <li><tt>Sin</tt>, <tt>Cos</tt>, <tt>Tan</tt>, <tt>CoTan</tt>
      <li><tt>ArcSin</tt>, <tt>ArcCos</tt>, <tt>ArcTan</tt>, <tt>ArcCoTan</tt>
      <li><tt>SinH</tt>, <tt>CosH</tt>, <tt>TanH</tt>, <tt>CoTanH</tt>
      <li><tt>Log2</tt>, <tt>Ln</tt>, <tt>Log</tt>, <tt>Power2</tt>,
        <tt>Exp</tt>, <tt>Power</tt>, <tt>Sqr</tt>, <tt>Sqrt</tt><br>
        (<tt>Log2(x) = Log(2, x)</tt>,
         <tt>Power2(x) = Power(2, x) = 2^x</tt>,
         <tt>Exp(x) = Power(enat, x) = enat^x</tt>)
      <li><tt>Sgn</tt>, <tt>Abs</tt>, <tt>Ceil</tt>, <tt>Floor</tt>
      <li><tt>Greater</tt>, <tt>Lesser</tt>, <tt>GreaterEq</tt>,
        <tt>LesserEq</tt>, <tt>Equal</tt>, <tt>NotEqual</tt><br>
        (zwracaj� 0 (fa�sz) lub 1 (prawda))
      <li><tt>Or</tt>, <tt>And</tt>, <tt>Not</tt><br>
        (zwracaj� 0 (fa�sz) lub 1 (prawda), jako argumenty bior� dwie
        (<tt>Or</tt>, <tt>And</tt>) lub jedn� (<tt>Not</tt>) liczby i
        traktuj� 0 jako fa�sz i wszystko inne jako prawd�)
    </ul>
    <!--
    (sa to wszystkie nazwy funkcji poza tymi realizowanymi
    przez operatory 2-argumentowe +-*/ i 1-argumentowy -.
    Wszystkie one maja okreslona liczbe parametrow
    w odpowiednim FunctionKind[].argsCount.)
    -->
  <li>Por�wnanie w nawiasach klamrowych, tzn.
    <tt>[ wyra�enie_1 operator wyra�enie_2 ]</tt>,
    gdzie operator to <tt>&lt;, &gt;, &lt;=, &gt;=, = lub &lt;&gt;</tt>.
    Przyk�ad: <tt>[ x &gt; 3 ]</tt>. Warto�ci� takiego czynnika jest 1
    gdy zale�no�c jest spe�niona lub 0 je�li nie.
    To jest uproszczona posta� konwencji Iversona.
    <!--
    Jest to uproszczona
    postac konwencji zapisu Kennetha E. Iversona (ktora zobaczylem
    w "Matematyce konkretnej" Grahama, Knutha i Patashnika).
    Notka - aby robic operacje w rodzaju not, or czy and uzywaj
    odpowiednich funkcji operujacych na liczbach.
    Powyzsza notacja tez jest zreszta tylko bardzo wygodnym skrotem
    dla odpowiednich funkcji Greater, Lesser, GreaterEq itd. )
    -->
</ul>

<p><b>Dwuargumentowe operatory <tt>/, *, ^, %</tt></b> wykonuj� odpowiednio
dzielenie, mno�enie, pot�gowanie i zwracaj� reszt� z dzielenia (modulo).
Wszystkie maj� ten sam priorytet i ��cz� w lewo.
Modulo jest liczone jako <tt>x % y = x - Floor(x/y) * y</tt>.
W wyra�eniu <tt>x^y</tt> je�eli y nie jest liczb� ca�kowit� to x musi by�
&gt;=0.

<!--
(wszystko jest na wartosciach rzeczywistych;
pamietaj tez ze operator potegowania ma taki sam priorytet jak
np. mnozenie a operatory o rownym priorytecie sa obliczane od
lewej do prawej wiec np. 2*4^2 = 8^2, nie 2*16))
-->

<p><b>Dwuargumentowe operatory <tt>+ i -</tt></b> wykonuj� dodawanie i
odejmowanie. One te� ��cz� w lewo. Maj� s�abszy priorytet od
operator�w multiplikatywnych powy�ej, wi�c np.
<tt>12 + 3 * 4</tt> daje 24.

<p>Du�e / ma�e litery w nazwach funkcji, sta�ych i zmiennych nie s�
rozr�niane.

<p>Przyk�ady:
<pre>
  sin(x) ^ 10
  2 * (cos(ln(x)) - 1)
  [sin(x) > cos(x)]
  or( [sin(x) > cos(x)], [sin(x) > 0] )
</pre>

<!--
- wylaczyc wykres 2, i 3
- podstawowe klawisze : +, - (skalowanie), strzalki (przesuwanie)
- wylaczyc siatke co 1, wlaczyc siatke + liczby co Pi
- potem wlaczyc 2, albo 3 i zaobserwowac ze wszystko sie zgadza -
  uzyc klawisza q aby zobaczyc Prawde
- reszta klawiszy : F10 (savescreen),
  pomocne zabaweczki - celownik, pktcoords, grid/ podzialka/ liczby custom,
    obracanie
- esc (wyjscie)

do tutoriala  notki o sk�adni wyra�en. Notka o u�yteczno�ci notacji
  Iversona i og�lniej f-cji boolowskich np. maj�c dan� funkcj�
  f(x) i chc�c by by�a okre�lona tylko gdy dane wyra�enie W boolowskie
  (a wiec 1 = true, 0 = false) bylo true wystarczy zrobic
  g(x) = f(x) / W (gdy W = 0 czyni funkcje nieokreslona,
  gdy W = 1 czyni g(x) = f(x))
-->

<?php
  if (!IS_GEN_LOCAL) {
    $counter = php_counter("gen_funkcja", TRUE);
  };

  camelot_footer();
?>