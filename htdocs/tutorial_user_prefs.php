<?php
require_once 'castle_engine_functions.php';
tutorial_header('Persistent data (user preferences, savegames)');
?>

<p>To manage persistent data, like user preferences
or a simple <i>save game</i> values,
use <?php api_link('CastleConfig', 'CastleConfig.html'); ?> unit
with a <code>UserConfig</code> singleton inside. A simple example:</p>

<?php echo pascal_highlight(
'uses SysUtils, CastleWindow, CastleConfig;

var
  Window: TCastleWindow;
  MyParameter: string;

function MyGetApplicationName: string;
begin
  Result := \'my_game_name\';
end;

begin
  { make sure application name is correct by setting OnGetApplicationName,
    this is used by UserConfig.Load to determine config file location. }
  OnGetApplicationName := @MyGetApplicationName;

  { load config from file }
  UserConfig.Load;
  // SoundEngine.LoadFromConfig(UserConfig); // load sound parameters (enabled, volume...)
  // InputsAll.LoadFromConfig(UserConfig); // load keyboard shortcuts configuration

  { load your own data like this: }
  MyParameter := UserConfig.GetValue(\'my_parameter\', \'default_value\');

  { ... do the main part of your program }
  Window := TCastleWindow.Create(Application);
  Window.OpenAndRun;

  { save your own data like this: }
  UserConfig.SetValue(\'my_parameter\', MyParameter);
  // or like this:
  UserConfig.SetDeleteValue(\'my_parameter\', MyParameter, \'default_value\');

  { save config to file }
  // SoundEngine.SaveToConfig(UserConfig); // save sound configuration
  // InputsAll.SaveToConfig(UserConfig); // save keyboard shortcuts configuration
  UserConfig.Save;
end.'); ?>

<p>To load and save config values, you should use <code>GetValue</code>
and <code>SetValue</code> (or <code>SetDeleteValue</code>) methods.
See the <a href="http://wiki.freepascal.org/xmlconf"><code>TXMLConfig</code>
class documentation</a>. These provide basic means to load/save
integers, booleans and strings in a simple XML format.

<p>We extend the standard <code>TXMLConfig</code> with more
methods:
<ul>
  <li>to load/save more types (floats, vectors, colors, URLs),
  <li>to load/save from an URL (not just a filename),
  <li>to encrypt/decrypt contents, which may be useful as a simple protection
    against cheaters (if you want this, just set the simple <code>BlowFishKeyPhrase</code> property).
</ul>

<p>See the <?php api_link('TCastleConfig', 'CastleXMLConfig.TCastleConfig.html'); ?>
 for a documentation of our extensions.

<p>Some engine components provide ready methods to load / save
their configuration into a
<?php api_link('TCastleConfig', 'CastleXMLConfig.TCastleConfig.html'); ?> instance
(for example into the <code>UserConfig</code>). These include:

<ul>
  <li><?php api_link('SoundEngine', 'CastleSoundEngine.html#SoundEngine'); ?>
    &mdash; can load/save sound enabled state, sound volume and other parameters.
    See
    <?php api_link('TSoundEngine.LoadFromConfig', 'CastleSoundEngine.TSoundEngine.html#LoadFromConfig'); ?>,
    <?php api_link('TSoundEngine.SaveToConfig', 'CastleSoundEngine.TSoundEngine.html#SaveToConfig'); ?>.

  <li><?php api_link('InputsAll', 'CastleInputs.html#InputsAll'); ?>
    &mdash; input shortcuts (named key and mouse shortcuts) customizations. See
    <?php api_link('TInputShortcutList.LoadFromConfig', 'CastleInputs.TInputShortcutList.html#LoadFromConfig'); ?>,
    <?php api_link('TInputShortcutList.SaveToConfig', 'CastleInputs.TInputShortcutList.html#SaveToConfig'); ?>.
</ul>

<p>Note that the engine does <b>not</b> automatically
call the load / save methods mentioned above. We used to call them automatically
(in engine version &lt;= 5.2.0), but this automatization was more trouble
than gain. <small>(It meant that <code>UserConfig.Load</code> could, often by surprise
to the developer, override the sound parameters set by
<code>SoundEngine.ParseParameters</code> or explicit
<code>SoundEngine.Enabled := false</code> code.)</small>
So you're supposed to call them yourself (see example above) if you want to save
these values as user preferences.

<p>While you can load and save the config data at any time,
you can also register your own load and save listeners using
the
<?php api_link('TCastleConfig.AddLoadListener', 'CastleXMLConfig.TCastleConfig.html#AddLoadListener'); ?>,
<?php api_link('TCastleConfig.AddSaveListener', 'CastleXMLConfig.TCastleConfig.html#AddSaveListener'); ?>
 mechanism. This sometimes allows to decentralize your code better.

<?php
tutorial_footer();
?>
