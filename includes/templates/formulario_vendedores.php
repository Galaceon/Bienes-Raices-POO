<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre Vendedor" value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor" value="<?php echo s($vendedor->apellido); ?>">

</fieldset>

<fieldset>
    <legend>Información Extra</legend>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Teléfono Vendedor" value="<?php echo s($vendedor->telefono); ?>">

    <label for="email">Email:</label>
    <input type="email" id="email" name="vendedor[email]" placeholder="Email Vendedor" value="<?php echo s($vendedor->email); ?>">

    <label for="imagen">imagen:</label>
    <input type="file" id="imagen" accept="image/jpg, image/png, image/jpeg" name="vendedor[imagen]">

    <?php if($vendedor->imagen) { ?>
        <img src="/fotos/<?php echo $vendedor->imagen ?>" class="imagen-small">
    <?php } ?>

</fieldset>