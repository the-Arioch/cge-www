<?php
require_once 'castle_engine_functions.php';

api_links_to_unstable();

castle_header('Physics');
?>

<p><a href="index.php">Castle Game Engine</a> is integrated with <a href="https://github.com/BeRo1985/kraft">Kraft Physics Engine</a> made by <i>Benjamin 'BeRo' Rosseaux</i>. Read on to learn how to add rigid-body physics to your own games.

<div class="thumbnails">
  <iframe width="300" height="168" src="https://www.youtube.com/embed/8k9zX6dPQEU" frameborder="0" allowfullscreen></iframe>
  <iframe width="300" height="168" src="https://www.youtube.com/embed/hIuEGnRm-yM" frameborder="0" allowfullscreen></iframe>
</div>

<h2>Usage</h2>

<p>You can turn any <?php api_link('TCastleTransform', 'CastleTransform.TCastleTransform.html'); ?> instance into a <i>rigid body</i>, which means that it will be affected by gravity and collisions with other rigid bodies. <?php api_link('TCastleScene', 'CastleScene.TCastleScene.html'); ?>, which you use to render 3D objects, is a descendant of <?php api_link('TCastleTransform', 'CastleTransform.TCastleTransform.html'); ?>, so this implies that <code>TCastleScene</code> can be a <i>rigid body</i> too. Or you can use <?php api_link('TCastleTransform', 'CastleTransform.TCastleTransform.html'); ?> as a container for other transformations and scenes inside, and thus a group of objects can be treated as a single rigid body.

<p>To make a rigid body you need to:

<ol>
  <li><p>Create a
    <?php api_link('TCastleScene', 'CastleScene.TCastleScene.html'); ?>
    (see also <a href="manual_scene.php">the manual chapter about transforming scene</a>).
  <li><p>Create and configure an instance of <?php api_link('TRigidBody', 'CastleTransform.TRigidBody.html'); ?>.
  <li><p>Create and configure an instance of some <?php api_link('TCollider', 'CastleTransform.TCollider.html'); ?> descendant,
    like
    <?php api_link('TPlaneCollider', 'CastleTransform.TPlaneCollider.html'); ?>,
    <?php api_link('TBoxCollider', 'CastleTransform.TBoxCollider.html'); ?>,
    <?php api_link('TSphereCollider', 'CastleTransform.TSphereCollider.html'); ?>,
    <?php api_link('TMeshCollider', 'CastleSceneCore.TMeshCollider.html'); ?>.
    It will be connected to the parent rigid body at construction (the <?php api_link('TRigidBody.Collider', 'CastleTransform.TRigidBody.html#Collider'); ?> property will be automatically set when creating the collider).
  <li><p>Link to your rigid body from the <?php api_link('TCastleTransform.RigidBody', 'CastleTransform.TCastleTransform.html#RigidBody'); ?> property.
</ol>

<p>This is a sample code:</p>

<?php echo pascal_highlight(
'var
  Scene: TCastleScene;
  RigidBody: TRigidBody;
  Collider: TBoxCollider;
begin
  // Create TCastleScene
  Scene := TCastleScene.Create(Application);
  Scene.Load(URL);
  Scene.Spatial := [ssRendering, ssDynamicCollisions];
  // Scene.Translation := Vector3(1, 2, 3); // set initial position

  // Create TRigidBody
  RigidBody := TRigidBody.Create(Application);
  // RigidBody.Dynamic := ?; // boolean, default true
  // RigidBody.Gravity := ?; // boolean, default true
  // RigidBody.InitialLinearVelocity := Vector3(10, 0, 0);

  // Create TCollider (a TBoxCollider, to be more precise, in this case).
  // Note that TBoxCollider assumes that box is centered around (0,0,0) for now
  Collider := TBoxCollider.Create(RigidBody);
  Collider.Size := Scene.BoundingBox.Size;
  // Collider.Restitution := 0.3;
  // Collider.Density := 100.0;

  // Connect rigid body
  Scene.RigidBody := RigidBody;

  // Add Scene to the Viewport, to make it visible
  Viewport.Items.Add(Scene);
end;'); ?>

<p>See <a href="https://github.com/castle-engine/castle-engine/blob/master/examples/physics/physics_3d_demo/">physics_3d_demo</a>, in particular the <a href="https://github.com/castle-engine/castle-engine/blob/master/examples/physics/physics_3d_demo/gameinitialize.pas">physics_3d_demo/gameinitialize.pas</a> source code, for a complete working example.

<p>Notes:

<ul>
  <li><p>Right now the instruction to assign <?php api_link('TCastleTransform.RigidBody', 'CastleTransform.TCastleTransform.html#RigidBody'); ?> should be at the very end, when you configured all the rigid body and collider parameters. Right now, this is when the rigid body is actually created on the physics engine side. <i>Right now</i> changing the properties of rigid body or collider later has no effect (if you need it, the temporary workaround is to set <code>TCastleTransform.RigidBody</code> to <code>nil</code> and then again to your <code>TRigidBody</code> instance).

  <li><p>The collider shape is not synchronized with the scene shape in any way. This also applies to the <?php api_link('TMeshCollider', 'CastleSceneCore.TMeshCollider.html'); ?> that has a
  <?php api_link('Scene property', 'CastleSceneCore.TMeshCollider.html#Scene'); ?>: the mesh is created <i>once</i> from the scene geometry, it is not synchronized with scene changes later. (If you need it, the workaround is the same as above: set <code>TCastleTransform.RigidBody</code> to <code>nil</code> and then again to your <code>TRigidBody</code> instance. But creating a mesh collider is a costly operation, so think twice before doing this during the game!)
</ul>

<h2>2D games</h2>

<p>Although internally Castle Game Engine and Kraft work in 3D, the physics can work just fine for 2D games too.

<ul>
  <li>Simply position everything around Z = 0 (or any other Z = constant plane).
  <li>When creating colliders, make sure that they have some non-zero size in Z axis too. Even though the Z axis is not visible in 2D games, but the colliders need to have some volume in all 3 axes.
  <li>Constrain rotations and movement of dynamic rigid bodies to 2D by calling <?php api_link('TRigidBody.Setup2D', 'CastleTransform.TRigidBody.html#Setup2D'); ?>.
</ul>

<p>The example how to do this is in <a href="https://github.com/castle-engine/castle-engine/tree/master/examples/physics/physics_2d_game_sopwith">physics_2d_game_sopwith</a> (see in particular the <a href="https://github.com/castle-engine/castle-engine/tree/master/examples/physics/physics_2d_game_sopwith/gameinitialize.pas">physics_2d_game_sopwith/gameinitialize.pas</a> source code).

<h2>Future plans (TODOs)</h2>

<p>Current physics engine integration is just a start. Michalis wants to dedicate a whole <i>Castle Game Engine</i> release in the future toward extending the physics. The plans are:

<ul>
  <li><p>A shape within the TCastleScene should be able to act like a rigid body, independent of the rest of the scene. Ideally, this should be <a href="creating_data_blender.php">configurable in Blender, and exported nicely to X3D</a>. <a href="http://www.web3d.org/documents/specifications/19775-1/V3.3/Part01/components/rigid_physics.html">The X3D specification has a rigid-body component</a> to describe such things.

  <li><p>Currently we also have an older, simpler, internal physics/collision engine in CGE, that takes care of some tasks: the collisions of player and creatures (from CastleCreatures), a simple gravity for them, and custom collision methods for you (like RayCollision, SphereCollision etc. in CastleTransform unit). The new physics engine can probably replace them all, and there should be a flag to make it possible, and eventually it should even become the default, and the old collision implementation should be simply removed.

  <li><p>The current implementation doesn't expose any API for joints. Again, they could be designed in Blender and exported to X3D.

  <li><p>In the past, I planned integration with other physics engines, through a layer providing a common API. However, right now, I'm extremely satisfied with <a href="https://github.com/BeRo1985/kraft">Kraft</a>. As far as rigid body simulation goes, I think that Kraft may be <i>the</i> physics engine for us, and we may not need anything else... But just in case, here are other options I considered:

    <ul>
      <li><p><a href="http://bulletphysics.org/">Bullet</a>. Very full-featured, e.g. there's soft body, not only rigid body.

        <p>Full integration with Bullet will require proper translation of Bullet API to C and then to Pascal (as Bullet is in C++, it's not readily usable from anything other than C++). There is a C header for Bullet, see <a href="https://code.google.com/archive/p/bullet/issues/43">this old Google Code issue</a> and <a href="https://github.com/bulletphysics/bullet3/issues/130">this GitHub issue</a>, but it's rather minimalistic (only rigid body), although it may be a good start.

      <li><p><a href="http://www.ode.org/">ODE</a>. A popular physics engine with simple C API. <a href="http://www.bvbcode.com/cn/pwd19hez-1586203">Old Pascal header here</a>. I don't see any advantages ODE has over Kraft, for now.
    </ul>
</ul>

<?php
castle_footer();
?>
