<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Prescription - Smart Hospital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
        }
        
        .page-header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
            position: relative;
        }
        
        .hospital-name {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        
        .prescription-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 2px;
        }
        
        .prescription-number {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }
        
        .section {
            margin-bottom: 20px;
            padding: 12px 0;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .patient-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: bold;
            min-width: 80px;
        }
        
        .vitals {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            background: #f8f9fa;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 8px;
        }
        
        .vital-item {
            text-align: center;
            font-size: 13px;
        }
        
        .vital-value {
            font-weight: bold;
            font-size: 16px;
            display: block;
        }
        
        .prescription-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            border: 2px solid #000;
        }
        
        .prescription-table th {
            background: #e8ecef !important;
            border: 1px solid #000;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .prescription-table td {
            border: 1px solid #000;
            padding: 12px 8px;
            vertical-align: top;
            font-size: 12px;
        }
        
        .medicine-name {
            font-weight: bold;
            font-size: 13px;
            background: #f8f9fa;
        }
        
        .days-column {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }
        
        .advice-section {
            background: #f0f8f0;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px solid #000;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        
        .signature-section {
            text-align: center;
            margin-left: 50px;
            flex: 1;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            margin: 60px 0 15px 0;
            height: 1px;
        }
        
        .doctor-name {
            font-weight: bold;
            font-size: 14px;
        }
        
        .registration {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        
        .stamp-area {
            width: 100px;
            height: 100px;
            border: 2px dashed #999;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #999;
            margin-left: auto;
        }
        
        @media print {
            body { 
                padding: 10px; 
                font-size: 11px;
            }
            .page-break { page-break-before: always; }
        }
        
        .rx-symbol {
            position: absolute;
            top: -10px;
            right: 20px;
            font-size: 36px;
            font-weight: bold;
            color: #dc3545;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="rx-symbol"></div>
        <div class="hospital-name">Smart Hospital</div>
        <div class="prescription-title">Medical Prescription</div>
        <div class="prescription-number">Prescription #{{ $prescription->id ?? 'N/A' }}</div>
    </div>

    <div class="section">
        <div class="patient-info">
            <div>
                <div class="info-row">
                    <span class="info-label">Patient:</span>
                    <span>{{ $prescription->consultation->patient->user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Doctor:</span>
                    <span>{{ $prescription->consultation->doctor->name }}</span>
                </div>
            </div>
            <div>
                <div class="info-row">
                    <span class="info-label">Date:</span>
                    <span>{{ now()->format('d M Y, h:i A') }}</span>
                </div>
                @if($prescription->consultation->follow_up_at)
                <div class="info-row">
                    <span class="info-label">Follow-up:</span>
                    <span>{{ $prescription->consultation->follow_up_at->format('d M Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        @if($prescription->consultation->vitals)
        <div class="vitals">
            @if($prescription->consultation->vitals['bp'])
                <div class="vital-item">
                    <span>BP</span>
                    <span class="vital-value">{{ $prescription->consultation->vitals['bp'] }}</span>
                </div>
            @endif
            @if($prescription->consultation->vitals['pulse'])
                <div class="vital-item">
                    <span>Pulse</span>
                    <span class="vital-value">{{ $prescription->consultation->vitals['pulse'] }}</span>
                </div>
            @endif
            @if($prescription->consultation->vitals['temp'])
                <div class="vital-item">
                    <span>Temp</span>
                    <span class="vital-value">{{ $prescription->consultation->vitals['temp'] }}°F</span>
                </div>
            @endif
        </div>
        @endif
    </div>

    @if($prescription->consultation->diagnosis)
    <div class="section">
        <div class="section-title">Diagnosis</div>
        <div style="white-space: pre-wrap; line-height: 1.5;">{{ $prescription->consultation->diagnosis }}</div>
    </div>
    @endif

    <div class="section">
        <div class="section-title">Medication Orders</div>
        <table class="prescription-table">
            <thead>
                <tr>
                    <th style="width: 30%;">Medicine</th>
                    <th style="width: 35%;">Dosage</th>
                    <th style="width: 10%;">Days</th>
                    <th style="width: 25%;">Instructions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescription->items as $item)
                <tr>
                    <td class="medicine-name">{{ $item->medicine_name }}</td>
                    <td>{{ $item->dosage }}</td>
                    <td class="days-column">{{ $item->days }}</td>
                    <td>{{ $item->notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($prescription->advice)
    <div class="advice-section">
        <div class="section-title" style="text-transform: none; text-decoration: none; margin-bottom: 10px;">🩺 Patient Instructions</div>
        <div style="white-space: pre-wrap; line-height: 1.6; font-style: italic;">{{ $prescription->advice }}</div>
    </div>
    @endif

    <div class="footer">
        <div class="signature-section">
            <div class="signature-line"></div>
            <div class="doctor-name">{{ $prescription->consultation->doctor->name }}</div>
            <div class="registration">Reg. No: BMDC-{{ rand(10000,99999) }}</div>
            <div style="margin-top: 30px; font-size: 11px;">Signature </div>
        </div>
        <!-- <div class="stamp-area">
            DOCTOR'S<br>STAMP
        </div> -->
    </div>

</body>
</html>
