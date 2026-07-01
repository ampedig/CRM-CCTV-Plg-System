document.addEventListener("DOMContentLoaded", () => {
    // 1. Inisialisasi Grafik Penjualan (ApexCharts)
    const revenueChartEl = document.querySelector("#revenueChart");
    if (revenueChartEl) {
        // Ambil data dinamis dari backend Laravel yang dilempar lewat window.dashboardData
        const chartLabels = window.dashboardData?.labels || ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"];
        const incomeData = window.dashboardData?.income || [0, 0, 0, 0, 0, 0, 0];
        const pendingData = window.dashboardData?.pending || [0, 0, 0, 0, 0, 0, 0];

        const options = {
            series: [
                {
                    name: "Income (Lunas)", // Transaksi dengan status 'paid'
                    data: incomeData
                },
                {
                    name: "Pending", // Transaksi dengan status 'pending' (piutang/potensi)
                    data: pendingData
                }
            ],
            chart: {
                height: 350,
                type: "area",
                fontFamily: "'Work Sans', sans-serif",
                toolbar: { show: false },
                animations: { enabled: true, easing: "easeinout", speed: 800 }
            },
            dataLabels: { enabled: false },
            stroke: { curve: "smooth", width: 3 },
            colors: [
                window.getThemeColor("--color-brand-500"), 
                window.getThemeColor("--color-accent-500")
            ],
            xaxis: {
                categories: chartLabels,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: "#64748b",
                        fontSize: "12px",
                        fontFamily: "'Work Sans', sans-serif"
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: "#64748b",
                        fontSize: "12px",
                        fontFamily: "'Work Sans', sans-serif"
                    },
                    formatter: (value) => {
                        // Memformat nominal rupiah agar ringkas di sumbu Y (misal: 1.5jt, 500rb)
                        if (value >= 1e6) {
                            return (value / 1e6).toFixed(1).replace(/\.0$/, '') + "jt";
                        }
                        if (value >= 1e3) {
                            return (value / 1e3).toFixed(1).replace(/\.0$/, '') + "rb";
                        }
                        return value;
                    }
                }
            },
            grid: {
                borderColor: "#f1f5f9",
                strokeDashArray: 4,
                yaxis: { lines: { show: true } }
            },
            fill: {
                type: "gradient",
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val.toLocaleString("id-ID");
                    }
                }
            },
            legend: { position: "top", horizontalAlign: "right" }
        };

        const chart = new ApexCharts(revenueChartEl, options);
        chart.render();
    }

    // 2. Inisialisasi Grafik Kategori Terlaris (ECharts)
    const userChartEl = document.getElementById("userChart");
    if (userChartEl) {
        const myChart = echarts.init(userChartEl);

        // Ambil data kategori produk paling diminati dari Laravel
        let pieData = [];
        const colors = [
            window.getThemeColor("--color-brand-500"), // Warna utama brand
            window.getThemeColor("--color-accent-500"), // Warna aksen brand
            "#f59e0b", // Amber/Oranye
            "#8b5cf6", // Ungu
            "#10b981"  // Hijau
        ];

        if (window.dashboardData?.popularCategories && window.dashboardData.popularCategories.length > 0) {
            pieData = window.dashboardData.popularCategories.map((item, index) => {
                return {
                    value: parseInt(item.value),
                    name: item.name,
                    itemStyle: { color: colors[index % colors.length] }
                };
            });
        } else {
            // Data fallback jika data transaksi masih kosong
            pieData = [
                { value: 0, name: "Belum Ada Transaksi", itemStyle: { color: "#cbd5e1" } }
            ];
        }

        const option = {
            tooltip: { trigger: "item", formatter: "{b} : {c} unit ({d}%)" },
            legend: {
                bottom: 0,
                icon: "circle",
                itemWidth: 8,
                itemHeight: 8,
                textStyle: { color: "#64748b", fontSize: 12 }
            },
            series: [
                {
                    name: "Kategori Produk",
                    type: "pie",
                    radius: ["40%", "70%"],
                    center: ["50%", "45%"],
                    itemStyle: { borderRadius: 10, borderColor: "#fff", borderWidth: 2 },
                    label: { show: true },
                    emphasis: {
                        label: { show: true, fontSize: "16", fontWeight: "600", color: "#1e293b" }
                    },
                    labelLine: { show: true },
                    data: pieData
                }
            ]
        };
        myChart.setOption(option);
        window.addEventListener("resize", () => {
            myChart.resize();
        });
    }
});