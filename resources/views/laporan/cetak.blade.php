<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>MINIT CURAI</title>
    <style type="text/css"></style>
</head>

<body>
    <h3 align=center>MINIT CURAI</h3>
    <h5 align=center>MESYUARAT LUAR / BENGKEL / KURSUS / PROGRAM</h5>
    <h5 align=center>JABATAN PENDIDIKAN NEGERI MELAKA</h5>
    <hr style="width:100%;text-align:left;margin-left:0">
    <br>
	
    <table width="100%" border="" align="center">
        <tr>
            <td><b>1. &nbsp;&nbsp;&nbsp;
                Mesyuarat luar / Bengkel / Kursus / Program:</b></td>
        </tr>
        <tr>
            <td>{{ $minitCurai->tajuk }}</td>
        </tr>
	<tr>
            <td><hr style="width:100%;text-align:left;margin-left:0"></td>
        </tr>
	<tr>
            <td><b>2. &nbsp;&nbsp;&nbsp;
                Anjuran:</b></td>
        </tr>
	<tr>
            <td>{{ $minitCurai->anjuran }}</td>
        </tr>
	<tr>
            <td><hr style="width:100%;text-align:left;margin-left:0"></td>
        </tr>
        <tr>
            <td><b>3. &nbsp;&nbsp;&nbsp;
                Tarikh / Masa / Tempat:</b></td>
        </tr>
        <tr>
            <td>{{ $minitCurai->tarikh }}, {{ $minitCurai->lokasi }}</td>
        </tr>
        <tr>
            <td><hr style="width:100%;text-align:left;margin-left:0"></td>
        </tr>
	<tr>
            <td><b>4. &nbsp;&nbsp;&nbsp;
                Pegawai Yang Terlibat:</b></td>
        </tr>
        <tr>
            <td>{{ $minitCurai->pegawai_terlibat }}</td>
        </tr>
	<tr>
            <td><hr style="width:100%;text-align:left;margin-left:0"></td>
        </tr>
       	<tr>
            <td><b>5. &nbsp;&nbsp;&nbsp;
                Isu / Isu Penting Mesyuarat luar / Bengkel / Kursus / Program:</b></td>
        </tr>
        <tr>
            <td>{{ $minitCurai->isu }}</td>
        </tr>
        <tr>
            <td><hr style="width:100%;text-align:left;margin-left:0"></td>
        </tr>
	<tr>
            <td><b>6. &nbsp;&nbsp;&nbsp;
                Nyatakan Tindakan Yang Mesti / Perlu Diambil:<b></td>
        </tr>
        <tr>
            <td>{{ $minitCurai->tindakan }}</td>
        </tr>
	<tr>
            <td></td>
        </tr>
	<tr>
            <td></td>
        </tr>
	</table>
    <br>
    <br>
    <br>
    <table width="100%" border="" align="center">
        <tr>
            <td>Tanda Tangan Pegawai</td>
            <td align="center">Tarikh</td>
        </tr>
        <tr>
            <td><br><br>
                ................................................
                <br>
            </td>
            <td align="center"><br><br>
                ................................................
                <br>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table width="100%" border="" align="center">
        <tr>
            <td><hr style="width:100%;text-align:left;margin-left:0"></td>
        </tr>
	<tr>
            <td>Arahan / Cadangan bagi Tindakan / Keputusan oleh Pengarah / Timbalan Pengarah :</td>
        </tr>
        <tr>
            <td></td>
        </tr>
	<tr>
            <td></td>
        </tr>
	
    </table>
    <br>
    <br>
    <br>
    <table width="100%" border="" align="center">
        <tr>
            <td>Tanda Tangan Pengarah / Timbalan Pengarah</td>
            <td align="center">Tarikh</td>
        </tr>
        <tr>
            <td><br><br>
                ................................................
                <br>
            </td>
            <td align="center"><br><br>
                ................................................
                <br>
            </td>
        </tr>
    </table>
    
</body>


</html>
