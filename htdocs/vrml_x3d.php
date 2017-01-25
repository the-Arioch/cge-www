<?php
  require_once 'castle_engine_functions.php';
  require_once 'x3d_implementation_common.php';
  vrmlx3d_header('Scene graph (X3D)');

  echo castle_thumbs(array(
    array('filename' => 'sunny_street_tree_hard.png', 'titlealt' => 'Close up shadows on the tree. Notice that leaves (modeled by alpha-test texture) also cast correct shadows.'),
//    array('filename' => 'castle_screen_3.png', 'titlealt' => 'Werewolves with shadows'),
//    array('filename' => 'rendered_texture_with_background.png', 'titlealt' => 'RenderedTexture with background and mirrors thrown in'),
    array('filename' => 'water_reflections.png', 'titlealt' => 'Water reflections by optimized GeneratedCubeMapTexture'),
//    array('filename' => 'tex3d_smoke.png', 'titlealt' => 'Fog from 3D noise'),
    array('filename' => 'rendered_texture_mirror_2.png', 'titlealt' => 'Mirrors by RenderedTexture, by Victor Amat'),
  ));

  echo pretty_heading($page_title);
?>

<!--p>The engine core is a <i>scene graph</i> using nodes defined by the X3D specification.-->

<p>Simplifying, X3D (and it's older version, VRML) is a file format for 3D models.
You will find that virtually any 3D modeling program can export to it,
for example <a href="http://www.blender.org/">Blender</a> includes
an X3D exporter (see also <?php echo
a_href_page('our Blending exporting notes', 'creating_data_blender'); ?>).</p>

<p>To start the fun, just create some X3D models
(or download them from the Internet, or grab our
<?php echo a_href_page('demo models', 'demo_models'); ?>)
and open them with our
<?php echo a_href_page('view3dscene', 'view3dscene'); ?>.</p>

<p>As a 3D file format, X3D is quite unique, as</p>

<ul>
  <li><p>It's not only a file format. It's actually a very flexible scene graph
    for 3D applications. <!-- It is the way to build and modify
    the 3D content in your applications. -->
    Every X3D node corresponds to a Pascal class with appropriate fields,
    and you can freely <a href="manual_scene.php#section_building_and_editing">create and modify X3D nodes at runtime</a>.
    <!--
    The fact that it has an associated file format
    (actually, more than once &mdash; XML encoding, classic encoding...)
    is just "an extra".--></li>

  <li><p>It's designed to describe <i>virtual 3D worlds</i>,
    not just static scenes.
    So you can express animations, interactive behaviors (e.g. open the door
    when user presses a handle), and scripting right inside the X3D file.
    Many advanced graphic effects are also possible, like
    <a href="x3d_implementation_cubemaptexturing.php">mirrors by generated cube map textures</a>,
    <a href="x3d_extensions_screen_effects.php">screen effects</a>,
    <a href="x3d_extensions_shadow_maps.php">shadow maps</a>,
    <a href="x3d_extensions_shadow_volumes.php">shadow volumes</a>,
    <a href="compositing_shaders.php">effects using GLSL shaders</a>
    and much more.</li>
</ul>

<p><b>Learning X3D</b>: Use this part of the documentation to learn
about the available X3D nodes and their fields.</p>

<ul>
  <li><p><?php echo a_href_page('The nodes in the official X3D specification', 'x3d_implementation_status'); ?>
    are divided into components. We list all the supported nodes,
    with links to their X3D specification.
    For some nodes, we also mention
    eventual caveats or simple extensions that we have implemented.
  </li>

  <li><p><?php echo a_href_page('The unofficial nodes that we add', 'x3d_larger_extensions.php'); ?>
    documents some cool graphic effects available in our engine
    through special X3D nodes.
  </li>

  <li><p>In any case, the <a href="http://www.web3d.org/standards">X3D specifications</a> are your ultimate resource to learn what you can do with X3D.</p>

    <!--
    The older versions were called VRML (VRML 1.0, then VRML 2.0 also
    known as VRML 97). Newer versions are called X3D (3.x).
    I collectively call them all <i>X3D</i> because our engine handles
    all versions of them. You probably want to use the newest one,
    X3D, whenever possible.</p-->
  </li>
</ul>

<?php vrmlx3d_footer(); ?>
