<!DOCTYPE html>
<html xmlns:office="urn:schemas-microsoft-com:office:office" xmlns:word="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
    <head>
        <style type="text/css">
            @page Section1 {size:595.45pt 841.7pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
            div.Section1 {page:Section1;}
            @page Section2 {size:841.7pt 595.45pt;mso-page-orientation:landscape;margin:1.25in 1.0in 1.25in 1.0in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
            div.Section2 {page:Section2;}
            #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            }

            #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            }

            #customers tr:nth-child(even){background-color: #f2f2f2;}

            #customers tr:hover {background-color: #ddd;}

            #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #04AA6D;
            color: white;
            }
            #heading{
                font-family: Arial, Helvetica, sans-serif;
                margin:2px 0 3px 0;
                display:block;
                text-align:center;
                font-weight: bold;
            }
            .divider{
                border:1px solid #04AA6D;
                margin:0;
            }
            #strong{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 1rem;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="Section2">
            <h1 id="heading">{{ $Judul }}</h1>
            <hr class="divider"/>
            <h2 id="heading">Dinas Pendidikan dan Kebudayaan Kabupaten Konawe</h2>
            <br/>
            <p id="strong">Data Version : {{ date("j, F Y");  }}</p>
            <table id="customers">
            <tr>
                <th>ID_BERKAS</th>
                <th>NAMA_BOX</th>
                <th>KODE_KLASIFIKASI</th>
                <th>INDEKS</th>
                <th>URAIAN</th>
                <th>TAHUN</th>
                <th>VOLUME</th>
                <th>KETERANGAN</th>
            </tr>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->box->nama }}</td>
                    <td>{{ $item->kode_klasifikasi }}</td>
                    <td>{{ $item->indeks }}</td>
                    <td>{{ $item->uraian }}</td>
                    <td>{{ $item->tahun }}</td>
                    <td>{{ $item->volume }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
            </table>
        </div>
    </body>
</html>