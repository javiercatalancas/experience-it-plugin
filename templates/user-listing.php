<form id="users-listing-search-form">
    
    <input type="text" name="search_name" id="search_term_name" placeholder="Nombre">
    <input type="text" id="search_term_surname1"placeholder="Apellido 1">
    <input type="text" id="search_term_surname2" placeholder="Apellido 2">
    <input type="text" id="search_term_email"placeholder="Correo electrónico">
    <button type="submit">Buscar</button>
</form>
<form id="reset-list">
    <button type="submit">Listado completo de Usuarios</button>
</form>
<div id="error-message" style="display:none">
    <p>Por favor, escriba un nombre, apellido o email</p>
</div>
<div id="no-data-found" style="display:none">
    <p>No tenemos registros</p>
</div>
<div id="users-listing-table">
    <table>
        <thead>
            <tr>
                <th>Nombre de Usuario</th>
                <th>Nombre</th>
                <th>Apellido1</th>
                <th>Apellido2</th>
                <th>Correo Electrónico</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="pagination" id="pagination-container">
    <ul id="pagination"></ul>
    </div>
</div>



