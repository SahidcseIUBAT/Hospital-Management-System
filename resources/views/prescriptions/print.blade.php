<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }
        .section {
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #f0f0f0;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Smart Hospital</h2>
        <p><strong>Medical Prescription</strong></p>
    </div>

    <div class="section">
        <strong>Patient:</strong> {{ $prescription->consultation->patient->user->name }} <br>
        <strong>Doctor:</strong> {{ $prescription->consultation->doctor->name }} <br>
        <strong>Date:</strong> {{ now()->format('d M Y') }}
    </div>

    <div class="section">
        <strong>Diagnosis:</strong><br>
        {{ $prescription->consultation->diagnosis ?? 'N/A' }}
    </div>

    <div class="section">
        <strong>Medicines</strong>
        <table>
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Dosage</th>
                    <th>Days</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescription->items as $item)
                <tr>
                    <td>{{ $item->medicine_name }}</td>
                    <td>{{ $item->dosage }}</td>
                    <td>{{ $item->days }}</td>
                    <td>{{ $item->notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <strong>Advice:</strong><br>
        {{ $prescription->advice ?? 'N/A' }}
    </div>

    <div class="footer">
        <p>__________________________</p>
        <strong>{{ $prescription->consultation->doctor->name }}</strong><br>
        Doctor Signature
    </div>

</body>
</html>
