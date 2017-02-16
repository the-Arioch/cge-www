<?php
define('CASTLE_GITHUB_NAME', 'castle-engine');

require_once 'castle_engine_functions.php';
castle_header("Getting Started", array(
  'path' => array('documentation'),
  'social_share_image' => CURRENT_URL . 'images/castle_game_engine_icon.png',
));

echo '<img src="images/castle_game_engine_icon.png"
  alt="Castle Game Engine icon"
  class="engine-icon" />';

//echo pretty_heading('Castle Game Engine Documentation', VERSION_CASTLE_GAME_ENGINE, 'Getting Started');
echo pretty_heading('Getting Started');
?>

<ul>
  <li><p>Install the <a href="http://lazarus.freepascal.org/">Lazarus</a> IDE.
    Alternatively, for advanced users:
    install just the command-line <a href="http://freepascal.org/">Free Pascal Compiler</a>.

  <li><p><?php echo a_href_page('Download the
    engine source code with examples', 'index'); ?>, unpack it anywhere.

  <li><p><b>If you use <a href="http://lazarus.freepascal.org/">Lazarus</a> for development</b>:

    <ol>
      <li><p>Open and <b>compile the package <code>castle_base.lpk</code></b>
        You will find it in the <code>castle_game_engine/packages/</code> subdirectory.
        Use the Lazarus menu item <i>"Package -&gt; Open Package File (.lpk)"</i>
        to open the package file, press <i>"Compile"</i> in a dialog that appears.

      <li><p>Then open and <b>compile the package <code>castle_window.lpk</code></b>.

        <p>Note: <i>do not</i> install the <code>castle_window</code> package.

      <li><p>Finally, open and <b>install the package <code>castle_components.lpk</code></b>.
        In the package dialog, the option to <i>"Install"</i> package is under the <i>"Use"</i> button.

        <!--p>Note: Installing the <code>castle_components</code> package
        will also automatically install the package <code>castle_base</code>,
        as a dependency. That's cool, let it happen.-->
    </ol>

    <p>Once <code>castle_components.lpk</code> is successfully installed,
    Lazarus restarts, and you should see the <i>"Castle"</i> tab
    with our components.
    <!--
     at the top (TODO: screenshot). Sorry,
    we don't have icons for our components yet, so it looks a little
    boring. Mouse over the icons to see component names.--></p>

    <p><b>You're done:)</b>
    Now compile and run from Lazarus any engine example.
    Open the project file (<code>xxx.lpi</code>) using Lazarus,
    and compile and run.
    A good examples to try at the beginning are
    <code>examples/fps_game/fps_game.lpi</code> and
    <code>examples/lazarus/model_3d_viewer/</code>.</p>

    <p>From Lazarus, you can use the engine integrated
    with Lazarus forms (and the rest of the <i>Lazarus Component Library</i>)
    through the
    <?php api_link('TCastleControl', 'CastleControl.TCastleControl.html'); ?> class.
    Or you can use Lazarus only as an editor and debugger,
    and use the engine without the Lazarus forms,
    initializing the window using the
    <?php api_link('TCastleWindow', 'CastleWindow.TCastleWindow.html'); ?> class.

  <li><p><b>If you don't use Lazarus (only command-line FPC)</b>:

    <p>Our engine can be used without the LCL (<i>Lazarus Component Library</i>)
    through the
    <?php api_link('TCastleWindow', 'CastleWindow.TCastleWindow.html'); ?> class.
    To compile the engine and applications without the help of Lazarus,
    you have a couple of options:

    <ol>
      <li><p>Use simple shell scripts that call FPC with proper
        command-line options. They pass to FPC file <code>castle-fpc.cfg</code>
        that contains engine paths and compilation options.
        Just try compiling any example program this way.
        A good examples to try at the beginning is
        <code>examples/fps_game/fps_game.lpr</code>, so do

<pre>
cd examples/fps_game/
./fps_game_compile.sh
</pre>

        <p>And run the resulting executable (run <code>./fps_game</code>
        on Unix, or <code>fps_game.exe</code> on Windows).
        You can use a similar approach as the <code>fps_game_compile.sh</code>
        script for your own programs.

        <!-- you can also do <code>make examples</code> at top-level -->

      <li><p>Once you get friendly with the engine, we highly advice using our
        <a href="https://github.com/castle-engine/castle-engine/wiki/Build-Tool">build tool</a>
        to compile and package your games. The build tool reads the project
        configuration from the <code>CastleEngineManifest.xml</code> file.
        It provides a lot of cool options, e.g. can easily
        package your Android game, or prepare compressed versions of your textures.
        <!-- First compile the build tool itself (<code>./tools/build-tool/castle-engine_compile.sh</code>), -->
        <!-- move  -->

      <li><p>Other option is to compile the engine
        units by executing <code>make</code> inside the
        <code>castle_game_engine/</code> directory.
        This  uses <a href="http://wiki.freepascal.org/FPMake">FpMake</a>.
        Then add the path with compiled units to your <code>fpc.cfg</code> file by
        adding a line like <code>-Fu.../castle_game_engine/units/x86_64-linux</code>
        (<?php echo FPC_CFG_DOCS; ?>).
    </ol>
</ul>

<!--
The explanations that actually the engine
main OpenGL initialization method is <b>not</b> the Lazarus TOpenGLControl
takes too much space.

<p>There are also some Lazarus packages and examples (e.g. to extend Lazarus
<code>TOpenGLControl</code> component), they have to be compiled from
within Lazarus. Although note that the engine doesn't require LCL
for anything.
these are not an
essential part of the engine for now.
The main way for
initializing OpenGL for games is by CastleWindow unit that doesn't depend on
any Lazarus units. -->

<h2>Make sure you have installed the necessary libraries</h2>

<p>Programs developed using our engine (engine examples, and your own programs too)
use a couple of libraries.
<!--
The full list of libraries is at the "Requirements" section at the documentation
of each program, and the
<a href="<?php echo reference_link(); ?>">reference</a>
also lists the libraries in the introduction section.
-->
In short, you will most likely want to have <i>LibPng, ZLib, GtkGLExt,
OpenAL, FreeType, and VorbisFile</i>.</p>

<ul>
  <li><i>On Windows</i> get the DLL files from the engine sources you just downloaded.
    They are in:
    <ul>
      <li>(32-bit) <code>castle_game_engine/tools/build-tool/data/external_libraries/i386-win32/</code> or
      <li>(64-bit) <code>castle_game_engine/tools/build-tool/data/external_libraries/x86_64-win64/</code> .
    </ul>

    <p>Place these DLL files somewhere on your $PATH, or just copy them to every directory
    with .exe files that you compile with our engine.</p>

    <p>Be sure to use the DLL files corresponding to your compiler &mdash; if you use FPC/Lazarus for 32-bits, then you make executable for 32-bits, and you should use DLLs for 32-bits. <i>Even if you work on 64-bit Windows.</i> If in doubt, just try the other ones:)

  <li><p><i>On Linux and FreeBSD</i> you should install these libraries
    using your favorite package manager.
    Remember to install <code>-dev</code> versions of these libraries too
    (if you're under Debian or similar distribution) to be able to compile
    programs that link to these libraries.

  <li><p><i>On Mac OS X</i>: <?php echo a_href_page('Mac OS X requirements are listed here',
    'macosx_requirements'); ?>.
</ul>

<!--
In general, for all OSes, see section
 in the documentation of programs and make sure that
you have appropriate libraries installed on your system.
-->

<div class="centered-download-wrapper">
<div class="download jumbotron">
<a class="btn btn-primary btn-lg" href="<?php echo CURRENT_URL; ?>manual_intro.php">Now go to our manual!</a>

<div style="margin-top: 1em;">..and create some cool games!:)

<p>It's really easy, and if you have any questions &mdash; please <a href="<?php echo FORUM_URL; ?>">ask on the forum</a>!
</div>

<?php echo download_donate_footer(); ?>
</div>
</div>

<?php
castle_footer();
?>
