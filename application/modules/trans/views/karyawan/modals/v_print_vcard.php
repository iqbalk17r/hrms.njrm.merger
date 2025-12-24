<style>
    .card-container {
        position: relative;
        width: 180mm;
        height: 110mm;
        font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        background-image: url('../assets/img/base_vcard.jpeg');
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        padding: 10mm;
        box-sizing: border-box;
        overflow: auto; /* biar tabel nggak ketutup */
    }

    .card-container p {
        margin: 0;
        font-size: 12pt;
        color: #000;
    }

    .card-container .name {
        font-size: 14pt;
        font-weight: bold;
        margin-bottom: 2px;
        margin-top: 100px;
    }

    .qr-image {
        width: 150px;
        height: 150px;
    }

    .info-table td {
        border: 1px solid #333; /* kontras biar kelihatan */
        padding: 6px;
        font-size: 11pt;
        background: #fff; /* biar tidak menyatu dengan background */
    }
</style>

<div class="card-container">
    <p class="name"><?php echo $employee_name; ?></p>
    <p><?php echo $position_name; ?></p>
    <p><?php echo $phone1; ?></p>
    <p><?php echo $email; ?></p>

    <table id="spread">
        <tr>
            <td>jjj</td>
        </tr>
    </table>
</div>
