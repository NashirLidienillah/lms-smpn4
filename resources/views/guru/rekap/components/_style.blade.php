{{-- CSS KHUSUS UNTUK MEMPERBAIKI TAMPILAN KERTAS --}}
<style>
    @media print {
        @page { 
            size: landscape; 
            margin: 1.5cm; 
        }
        body { 
            background-color: white !important; 
            color: black !important;
            -webkit-print-color-adjust: exact;
        }
        nav, aside, header, footer, .sidebar { 
            display: none !important; 
        }
        main, #app, .content, .container, .max-w-7xl { 
            width: 100% !important; 
            max-width: none !important; 
            margin: 0 !important; 
            padding: 0 !important; 
        }
        table { border-collapse: collapse !important; width: 100% !important; }
        th, td { border: 1px solid black !important; }
    }
</style>