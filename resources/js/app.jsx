
import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import '../css/app.css';

function App() {
    const [students, setStudents] = useState([]);
    const [schedules, setSchedules] = useState([]);
    const [semester, setSemester] = useState(null);
    const [events, setEvents] = useState([]);

    const [search, setSearch] = useState('');
    const [selectedStudent, setSelectedStudent] = useState(null);
    const [menuOpen, setMenuOpen] = useState(false);
    const [scheduleLoading, setScheduleLoading] = useState(true);
    const [eventLoading, setEventLoading] = useState(true);

    const today = new Date();

    const [calendarMonth, setCalendarMonth] = useState(
        new Date(today.getFullYear(), today.getMonth(), 1)
    );

    const [selectedDate, setSelectedDate] = useState(toDateKey(today));

    useEffect(() => {
        fetch('/students-data', {
            headers: { Accept: 'application/json' },
        })
            .then((response) => {
                if (!response.ok) throw new Error('Gagal mengambil mahasiswa');
                return response.json();
            })
            .then((data) => {
                setStudents(Array.isArray(data) ? data : data.data || []);
            })
            .catch((error) => console.error(error));

        fetch('/class-schedules-data', {
            headers: { Accept: 'application/json' },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Gagal mengambil jadwal mata kuliah');
                }
                return response.json();
            })
            .then((data) => {
                setSemester(data.semester || null);
                setSchedules(
                    Array.isArray(data.schedules) ? data.schedules : []
                );
            })
            .catch((error) => console.error(error))
            .finally(() => setScheduleLoading(false));

        fetch('/class-events-data', {
            headers: { Accept: 'application/json' },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Gagal mengambil agenda kelas');
                }
                return response.json();
            })
            .then((data) => {
                setEvents(Array.isArray(data) ? data : data.data || []);
            })
            .catch((error) => console.error(error))
            .finally(() => setEventLoading(false));
    }, []);

    const filteredStudents = students.filter((student) => {
        const keyword = search.toLowerCase();

        return (
            String(student.name || student.nama || '')
                .toLowerCase()
                .includes(keyword) ||
            String(student.nim || student.student_number || '')
                .toLowerCase()
                .includes(keyword)
        );
    });

    const getStudentName = (student) =>
        student.name || student.nama || 'Mahasiswa IF 1';

    const getStudentNim = (student) =>
        student.nim || student.student_number || '-';

    const getStudentPhoto = (student) =>
        student.photo_url ||
        student.photo ||
        student.foto ||
        `https://ui-avatars.com/api/?name=${encodeURIComponent(
            getStudentName(student)
        )}&background=172554&color=ffffff&size=256`;

    const selectedEvents = events.filter(
        (item) =>
            String(item.event_date || '').slice(0, 10) === selectedDate
    );

    const eventTypes = {
        assignment: 'TUGAS',
        exam: 'UJIAN',
        presentation: 'PRESENTASI',
        holiday: 'LIBUR',
        other: 'KEGIATAN',
    };

    return (
        <div className="min-h-screen bg-[#080d19] text-white">
            {/* NAVBAR */}
            <header className="sticky top-0 z-40 border-b border-white/10 bg-[#080d19]/90 backdrop-blur-xl">
                <nav className="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">
                    <a
                        href="#beranda"
                        className="text-xl font-black tracking-tight"
                    >
                        TIFONE<span className="text-cyan-400">.</span>
                        <span className="text-cyan-400">ALGORITHM</span>
                    </a>

                    <button
                        type="button"
                        onClick={() => setMenuOpen(!menuOpen)}
                        className="rounded-lg border border-white/15 px-3 py-2 md:hidden"
                        aria-label="Buka navigasi"
                        aria-expanded={menuOpen}
                    >
                        ☰
                    </button>

                    <div
                        className={`${
                            menuOpen ? 'flex' : 'hidden'
                        } absolute left-0 right-0 top-full flex-col gap-5 border-b border-white/10 bg-[#080d19] p-5 md:static md:flex md:flex-row md:items-center md:border-0 md:bg-transparent md:p-0`}
                    >
                        {[
                            ['Beranda', '#beranda'],
                            ['Jadwal Kuliah', '#jadwal'],
                            ['Kalender Akademik', '#kalender'],
                            ['Manifest', '#manifest'],
                            ['Mahasiswa', '#mahasiswa'],
                            ['Menfess', '#menfess'],
                        ].map(([label, href]) => (
                            <a
                                key={href}
                                href={href}
                                onClick={() => setMenuOpen(false)}
                                className="text-sm text-slate-300 transition hover:text-cyan-400"
                            >
                                {label}
                            </a>
                        ))}
                    </div>
                </nav>
            </header>

            <main>
                {/* HERO */}
                <section
                    id="beranda"
                    className="relative scroll-mt-24 overflow-hidden px-5 py-28 sm:py-36"
                >
                    <div className="pointer-events-none absolute left-1/2 top-10 h-80 w-80 -translate-x-1/2 rounded-full bg-blue-600/20 blur-[120px]" />

                    <div className="relative mx-auto max-w-5xl text-center">
                        <div className="mb-6 inline-flex rounded-full border border-cyan-400/25 bg-cyan-400/10 px-4 py-2 text-xs font-semibold tracking-[0.2em] text-cyan-300">
                            UNIVERSITAS KOMPUTER INDONESIA
                        </div>

                        <h1 className="text-5xl font-black leading-tight tracking-tight sm:text-7xl lg:text-8xl">
                            WE ARE
                            <span className="block bg-gradient-to-r from-cyan-300 via-blue-400 to-violet-400 bg-clip-text text-transparent">
                                IF 1.
                            </span>
                        </h1>

                        <p className="mx-auto mt-7 max-w-2xl text-base leading-8 text-slate-400 sm:text-lg">
                            Satu kelas, banyak cerita. Tempat kami belajar,
                            berkembang, berbagi ide, dan menciptakan kenangan
                            sebagai keluarga Teknik Informatika.
                        </p>

                        <div className="mt-10 flex flex-wrap justify-center gap-4">
                            <a
                                href="#mahasiswa"
                                className="rounded-xl bg-cyan-400 px-7 py-3.5 font-bold text-slate-950 transition hover:bg-cyan-300"
                            >
                                Kenali Kelas Kami ↗
                            </a>

                            <a
                                href="#manifest"
                                className="rounded-xl border border-white/15 px-7 py-3.5 font-semibold transition hover:border-cyan-400 hover:text-cyan-300"
                            >
                                Lihat Manifest
                            </a>
                        </div>

                        <div className="mx-auto mt-20 grid max-w-2xl grid-cols-3 gap-4">
                            {[
                                ['01', 'CLASS'],
                                ['IF 1', 'COMMUNITY'],
                                ['∞', 'MEMORIES'],
                            ].map(([number, label]) => (
                                <div
                                    key={label}
                                    className="rounded-2xl border border-white/10 bg-white/[0.03] p-5"
                                >
                                    <div className="text-2xl font-black text-cyan-300 sm:text-3xl">
                                        {number}
                                    </div>
                                    <div className="mt-2 text-[10px] tracking-[0.2em] text-slate-500 sm:text-xs">
                                        {label}
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* JADWAL MATA KULIAH */}
                <section
                    id="jadwal"
                    className="scroll-mt-24 border-t border-white/5 px-5 py-20"
                >
                    <div className="mx-auto max-w-7xl">
                        <SectionHeading
                            eyebrow="CLASS SCHEDULE"
                            title="Jadwal Kuliah."
                            description="Jadwal perkuliahan mahasiswa IF 1 berdasarkan semester yang sedang aktif."
                        />

                        <div className="mb-6 rounded-2xl border border-cyan-400/20 bg-cyan-400/5 p-5">
                            <p className="text-sm text-slate-400">
                                Semester aktif
                            </p>

                            <h3 className="mt-1 text-xl font-bold text-cyan-300">
                                {semester
                                    ? `${semester.name} • ${semester.academic_year}`
                                    : 'Belum ada semester aktif'}
                            </h3>

                            {semester?.start_date && semester?.end_date && (
                                <p className="mt-2 text-sm text-slate-400">
                                    {formatDate(semester.start_date)} –{' '}
                                    {formatDate(semester.end_date)}
                                </p>
                            )}
                        </div>

                        {scheduleLoading ? (
                            <EmptyState
                                title="Memuat jadwal kuliah..."
                                description="Sedang mengambil jadwal dari server."
                            />
                        ) : schedules.length === 0 ? (
                            <EmptyState
                                title="Jadwal belum tersedia"
                                description="Admin perlu mengaktifkan semester dan menambahkan jadwal mata kuliah terlebih dahulu."
                            />
                        ) : (
                            <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                {schedules.map((item, index) => (
                                    <article
                                        key={item.id || index}
                                        className="rounded-2xl border border-white/10 bg-white/[0.03] p-6 transition hover:-translate-y-1 hover:border-cyan-400/40"
                                    >
                                        <div className="flex items-start justify-between gap-3">
                                            <span className="rounded-full bg-cyan-400/10 px-3 py-1 text-xs font-semibold text-cyan-300">
                                                {item.day || 'Hari belum ditentukan'}
                                            </span>

                                            <span className="text-xs text-slate-500">
                                                {item.meeting_type === 'online'
                                                    ? 'Online'
                                                    : 'Tatap muka'}
                                            </span>
                                        </div>

                                        <h3 className="mt-5 text-xl font-bold">
                                            {item.subject}
                                        </h3>

                                        <p className="mt-2 text-sm text-slate-400">
                                            {item.lecturer ||
                                                'Dosen belum ditentukan'}
                                        </p>

                                        <div className="mt-5 space-y-3 border-t border-white/10 pt-4 text-sm">
                                            <div className="flex items-center gap-3">
                                                <span className="text-cyan-300">
                                                    ◷
                                                </span>
                                                <span className="text-slate-300">
                                                    {formatTime(item.start_time)}
                                                    {' – '}
                                                    {formatTime(item.end_time)}
                                                </span>
                                            </div>

                                            <div className="flex items-center gap-3">
                                                <span className="text-cyan-300">
                                                    ⌖
                                                </span>
                                                <span className="text-slate-300">
                                                    {item.room ||
                                                        'Ruangan belum ditentukan'}
                                                </span>
                                            </div>
                                        </div>

                                        {item.notes && (
                                            <p className="mt-4 text-sm leading-6 text-slate-400">
                                                {item.notes}
                                            </p>
                                        )}
                                    </article>
                                ))}
                            </div>
                        )}
                    </div>
                </section>

                {/* KALENDER AKADEMIK BULANAN */}
                <section
                    id="kalender"
                    className="scroll-mt-24 border-t border-white/5 bg-[#0b1221] px-5 py-20"
                >
                    <div className="mx-auto max-w-7xl">
                        <SectionHeading
                            eyebrow="ACADEMIC CALENDAR"
                            title="Kalender Akademik."
                            description="Pantau agenda perkuliahan, tugas, ujian, presentasi, dan kegiatan kelas IF 1 dalam satu kalender."
                        />

                        {eventLoading ? (
                            <EmptyState
                                title="Memuat kalender akademik..."
                                description="Sedang mengambil agenda dari server."
                            />
                        ) : (
                            <div className="grid gap-6 lg:grid-cols-[1.4fr_0.8fr]">
                                {/* KALENDER BULANAN */}
                                <div className="rounded-2xl border border-white/10 bg-[#080d19] p-4 sm:p-6">
                                    <div className="mb-6 flex items-center justify-between gap-3">
                                        <button
                                            type="button"
                                            onClick={() =>
                                                setCalendarMonth(
                                                    new Date(
                                                        calendarMonth.getFullYear(),
                                                        calendarMonth.getMonth() - 1,
                                                        1
                                                    )
                                                )
                                            }
                                            className="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-white/10 text-xl transition hover:border-cyan-400 hover:text-cyan-300"
                                            aria-label="Bulan sebelumnya"
                                        >
                                            ‹
                                        </button>

                                        <div className="text-center">
                                            <h3 className="text-xl font-black capitalize text-white sm:text-2xl">
                                                {calendarMonth.toLocaleDateString(
                                                    'id-ID',
                                                    {
                                                        month: 'long',
                                                        year: 'numeric',
                                                    }
                                                )}
                                            </h3>
                                            <p className="mt-1 text-xs text-slate-500">
                                                Kalender kegiatan IF 1
                                            </p>
                                        </div>

                                        <button
                                            type="button"
                                            onClick={() =>
                                                setCalendarMonth(
                                                    new Date(
                                                        calendarMonth.getFullYear(),
                                                        calendarMonth.getMonth() + 1,
                                                        1
                                                    )
                                                )
                                            }
                                            className="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-white/10 text-xl transition hover:border-cyan-400 hover:text-cyan-300"
                                            aria-label="Bulan berikutnya"
                                        >
                                            ›
                                        </button>
                                    </div>

                                    <div className="mb-3 grid grid-cols-7 gap-1 text-center">
                                        {[
                                            'Min',
                                            'Sen',
                                            'Sel',
                                            'Rab',
                                            'Kam',
                                            'Jum',
                                            'Sab',
                                        ].map((day) => (
                                            <div
                                                key={day}
                                                className="py-2 text-xs font-bold text-slate-500 sm:text-sm"
                                            >
                                                {day}
                                            </div>
                                        ))}
                                    </div>

                                    <div className="grid grid-cols-7 gap-1">
                                        {getCalendarDays(calendarMonth).map(
                                            ({ key, date }) => {
                                                if (!date) {
                                                    return (
                                                        <div
                                                            key={key}
                                                            className="aspect-square"
                                                        />
                                                    );
                                                }

                                                const dateKey = toDateKey(date);

                                                const dayEvents = events.filter(
                                                    (item) =>
                                                        String(
                                                            item.event_date || ''
                                                        ).slice(0, 10) === dateKey
                                                );

                                                const isSelected =
                                                    selectedDate === dateKey;

                                                const isToday =
                                                    toDateKey(new Date()) === dateKey;

                                                return (
                                                    <button
                                                        key={key}
                                                        type="button"
                                                        onClick={() =>
                                                            setSelectedDate(dateKey)
                                                        }
                                                        aria-pressed={isSelected}
                                                        aria-label={`${date.getDate()} ${date.toLocaleDateString(
                                                            'id-ID',
                                                            {
                                                                month: 'long',
                                                                year: 'numeric',
                                                            }
                                                        )}${
                                                            dayEvents.length
                                                                ? `, ${dayEvents.length} agenda`
                                                                : ''
                                                        }`}
                                                        className={`relative flex aspect-square flex-col items-center justify-center rounded-xl border text-sm transition sm:text-base ${
                                                            isSelected
                                                                ? 'border-cyan-300 bg-cyan-400 text-slate-950'
                                                                : isToday
                                                                  ? 'border-cyan-400/60 bg-cyan-400/10 text-cyan-300'
                                                                  : 'border-transparent text-slate-300 hover:border-white/20 hover:bg-white/5'
                                                        }`}
                                                    >
                                                        <span className="font-semibold">
                                                            {date.getDate()}
                                                        </span>

                                                        {dayEvents.length > 0 && (
                                                            <span
                                                                className={`mt-1 h-1.5 w-1.5 rounded-full ${
                                                                    isSelected
                                                                        ? 'bg-slate-950'
                                                                        : 'bg-cyan-300'
                                                                }`}
                                                            />
                                                        )}
                                                    </button>
                                                );
                                            }
                                        )}
                                    </div>

                                    <div className="mt-6 flex flex-wrap gap-4 border-t border-white/10 pt-5 text-xs text-slate-400">
                                        <div className="flex items-center gap-2">
                                            <span className="h-2.5 w-2.5 rounded-full bg-cyan-300" />
                                            Ada agenda
                                        </div>

                                        <div className="flex items-center gap-2">
                                            <span className="h-2.5 w-2.5 rounded-full border border-cyan-400" />
                                            Hari ini
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        onClick={() => {
                                            const now = new Date();

                                            setCalendarMonth(
                                                new Date(
                                                    now.getFullYear(),
                                                    now.getMonth(),
                                                    1
                                                )
                                            );

                                            setSelectedDate(toDateKey(now));
                                        }}
                                        className="mt-5 rounded-lg border border-white/10 px-4 py-2 text-xs font-semibold text-slate-300 transition hover:border-cyan-400 hover:text-cyan-300"
                                    >
                                        Kembali ke hari ini
                                    </button>
                                </div>

                                {/* DETAIL AGENDA TANGGAL TERPILIH */}
                                <div className="rounded-2xl border border-white/10 bg-[#080d19] p-5 sm:p-6">
                                    <p className="text-xs font-bold tracking-[0.2em] text-cyan-300">
                                        AGENDA TERPILIH
                                    </p>

                                    <h3 className="mt-3 text-xl font-black capitalize">
                                        {formatDate(selectedDate, true)}
                                    </h3>

                                    {selectedEvents.length === 0 ? (
                                        <div className="mt-6 rounded-xl border border-dashed border-white/10 p-6 text-center">
                                            <div className="text-3xl text-slate-600">
                                                ◷
                                            </div>

                                            <p className="mt-3 font-semibold text-slate-300">
                                                Tidak ada agenda
                                            </p>

                                            <p className="mt-2 text-sm leading-6 text-slate-500">
                                                Belum ada kegiatan yang
                                                dipublikasikan untuk tanggal ini.
                                            </p>
                                        </div>
                                    ) : (
                                        <div className="mt-6 space-y-4">
                                            {selectedEvents.map((item, index) => (
                                                <article
                                                    key={item.id || index}
                                                    className="rounded-xl border border-cyan-400/20 bg-cyan-400/[0.04] p-4"
                                                >
                                                    <span className="inline-block rounded-full bg-violet-400/10 px-3 py-1 text-[10px] font-bold tracking-wider text-violet-300">
                                                        {eventTypes[item.event_type] ||
                                                            'KEGIATAN'}
                                                    </span>

                                                    <h4 className="mt-3 text-lg font-bold">
                                                        {item.title}
                                                    </h4>

                                                    {(item.start_time ||
                                                        item.end_time) && (
                                                        <p className="mt-2 text-sm text-cyan-300">
                                                            ◷{' '}
                                                            {item.start_time
                                                                ? formatTime(
                                                                      item.start_time
                                                                  )
                                                                : 'Waktu belum ditentukan'}
                                                            {item.end_time
                                                                ? ` – ${formatTime(
                                                                      item.end_time
                                                                  )}`
                                                                : ''}
                                                        </p>
                                                    )}

                                                    {item.description && (
                                                        <p className="mt-3 whitespace-pre-wrap text-sm leading-6 text-slate-400">
                                                            {item.description}
                                                        </p>
                                                    )}

                                                    {item.location && (
                                                        <p className="mt-3 text-sm text-slate-300">
                                                            Lokasi: {item.location}
                                                        </p>
                                                    )}
                                                </article>
                                            ))}
                                        </div>
                                    )}
                                </div>
                            </div>
                        )}

                        {!eventLoading && events.length === 0 && (
                            <p className="mt-5 text-center text-xs text-slate-500">
                                Agenda akan muncul setelah admin menambahkan
                                dan memublikasikannya pada semester aktif.
                            </p>
                        )}
                    </div>
                </section>

                {/* MANIFEST */}
                <section
                    id="manifest"
                    className="scroll-mt-24 bg-[#0b1221] px-5 py-20"
                >
                    <div className="mx-auto max-w-7xl">
                        <SectionHeading
                            eyebrow="OUR MANIFEST"
                            title="Lebih dari sekadar kelas."
                            description="Kami mungkin datang dengan cerita berbeda, tetapi kami tumbuh bersama."
                        />

                        <div className="grid gap-5 md:grid-cols-3">
                            {[
                                {
                                    number: '01',
                                    title: 'Learn Together',
                                    description:
                                        'Saling membantu memahami materi, berbagi ilmu, dan berkembang bersama.',
                                    icon: '⌘',
                                },
                                {
                                    number: '02',
                                    title: 'Build Together',
                                    description:
                                        'Mengubah ide menjadi karya, proyek, dan pengalaman nyata.',
                                    icon: '</>',
                                },
                                {
                                    number: '03',
                                    title: 'Memories Forever',
                                    description:
                                        'Mengabadikan perjalanan, cerita, dan kenangan selama menjadi IF 1.',
                                    icon: '✳',
                                },
                            ].map((item) => (
                                <article
                                    key={item.number}
                                    className="rounded-2xl border border-white/10 bg-white/[0.03] p-7"
                                >
                                    <div className="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-400/10 font-black text-cyan-300">
                                        {item.icon}
                                    </div>

                                    <p className="mt-7 text-xs tracking-[0.2em] text-slate-500">
                                        {item.number} / MANIFEST
                                    </p>

                                    <h3 className="mt-3 text-xl font-bold">
                                        {item.title}
                                    </h3>

                                    <p className="mt-3 leading-7 text-slate-400">
                                        {item.description}
                                    </p>
                                </article>
                            ))}
                        </div>
                    </div>
                </section>

                {/* MAHASISWA */}
                <section
                    id="mahasiswa"
                    className="scroll-mt-24 px-5 py-20"
                >
                    <div className="mx-auto max-w-7xl">
                        <SectionHeading
                            eyebrow="THE PEOPLE"
                            title="Kenalan dengan kami."
                            description="Temukan teman seperjuanganmu di Teknik Informatika IF 1."
                        />

                        <div className="mx-auto mb-10 max-w-xl">
                            <div className="relative">
                                <input
                                    type="search"
                                    value={search}
                                    onChange={(event) =>
                                        setSearch(event.target.value)
                                    }
                                    placeholder="Cari nama atau NIM mahasiswa..."
                                    className="w-full rounded-xl border border-white/10 bg-white/[0.04] px-5 py-4 text-white outline-none transition placeholder:text-slate-500 focus:border-cyan-400"
                                />

                                <span className="absolute right-5 top-1/2 -translate-y-1/2 text-slate-500">
                                    ⌕
                                </span>
                            </div>
                        </div>

                        {students.length === 0 ? (
                            <EmptyState
                                title="Data mahasiswa belum tersedia"
                                description="Pastikan endpoint /students-data dan data mahasiswa di database sudah tersedia."
                            />
                        ) : filteredStudents.length === 0 ? (
                            <EmptyState
                                title="Mahasiswa tidak ditemukan"
                                description="Coba gunakan kata kunci nama atau NIM yang berbeda."
                            />
                        ) : (
                            <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                                {filteredStudents.map((student, index) => (
                                    <button
                                        key={student.id || index}
                                        type="button"
                                        onClick={() =>
                                            setSelectedStudent(student)
                                        }
                                        className="group overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03] text-left transition hover:-translate-y-1 hover:border-cyan-400/50"
                                    >
                                        <div className="aspect-square overflow-hidden bg-slate-800">
                                            <img
                                                src={getStudentPhoto(student)}
                                                alt={getStudentName(student)}
                                                loading="lazy"
                                                className="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                                onError={(event) => {
                                                    event.currentTarget.onerror = null;
                                                    event.currentTarget.src =
                                                        `https://ui-avatars.com/api/?name=${encodeURIComponent(
                                                            getStudentName(student)
                                                        )}&background=172554&color=ffffff`;
                                                }}
                                            />
                                        </div>

                                        <div className="p-4">
                                            <h3 className="line-clamp-2 font-bold">
                                                {getStudentName(student)}
                                            </h3>

                                            <p className="mt-2 text-xs text-slate-400">
                                                {getStudentNim(student)}
                                            </p>

                                            <p className="mt-4 text-xs font-semibold text-cyan-300">
                                                Lihat profil →
                                            </p>
                                        </div>
                                    </button>
                                ))}
                            </div>
                        )}

                        <p className="mt-8 text-center text-xs text-slate-500">
                            Menampilkan {filteredStudents.length} dari{' '}
                            {students.length} mahasiswa
                        </p>
                    </div>
                </section>

                {/* MENFESS */}
                <ConfessionSection />
            </main>

            {/* FOOTER */}
            <footer className="border-t border-white/10 bg-[#050912] px-5 py-10">
                <div className="mx-auto flex max-w-7xl flex-col justify-between gap-5 sm:flex-row sm:items-center">
                    <div>
                        <p className="text-lg font-black">
                            TIFONE<span className="text-cyan-400">.</span>
                            <span className="text-cyan-400">ALGORITHM</span>
                        </p>

                        <p className="mt-2 text-sm text-slate-500">
                            Ruang cerita, karya, dan kenangan IF 1.
                        </p>
                    </div>

                    <p className="text-xs text-slate-500">
                        © {new Date().getFullYear()} IF 1 UNIKOM. Dibuat dengan
                        semangat kebersamaan.
                    </p>
                </div>
            </footer>

            {/* MODAL PROFIL MAHASISWA */}
            {selectedStudent && (
                <Modal onClose={() => setSelectedStudent(null)}>
                    <div className="text-center">
                        <img
                            src={getStudentPhoto(selectedStudent)}
                            alt={getStudentName(selectedStudent)}
                            className="mx-auto h-28 w-28 rounded-full border-2 border-cyan-400 object-cover"
                        />

                        <h2 className="mt-5 text-2xl font-black">
                            {getStudentName(selectedStudent)}
                        </h2>

                        <p className="mt-2 text-sm text-cyan-300">
                            NIM: {getStudentNim(selectedStudent)}
                        </p>

                        {selectedStudent.bio && (
                            <p className="mt-4 leading-7 text-slate-400">
                                {selectedStudent.bio}
                            </p>
                        )}

                        {selectedStudent.instagram && (
                            <a
                                href={
                                    String(selectedStudent.instagram).startsWith('http')
                                        ? selectedStudent.instagram
                                        : `https://instagram.com/${String(
                                              selectedStudent.instagram
                                          ).replace('@', '')}`
                                }
                                target="_blank"
                                rel="noreferrer"
                                className="mt-5 inline-block rounded-lg border border-white/15 px-4 py-2 text-sm hover:border-cyan-400"
                            >
                                Instagram ↗
                            </a>
                        )}
                    </div>
                </Modal>
            )}
        </div>
    );
}

/* HELPER KALENDER */
function toDateKey(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

function getCalendarDays(monthDate) {
    const year = monthDate.getFullYear();
    const month = monthDate.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    return [
        ...Array.from({ length: firstDay }, (_, index) => ({
            key: `blank-${year}-${month}-${index}`,
            date: null,
        })),
        ...Array.from({ length: daysInMonth }, (_, index) => {
            const date = new Date(year, month, index + 1);

            return {
                key: toDateKey(date),
                date,
            };
        }),
    ];
}

function formatTime(value) {
    if (!value) return '--:--';
    return String(value).slice(0, 5);
}

function formatDate(value, withWeekday = false) {
    if (!value) return 'Tanggal belum tersedia';

    const date = new Date(`${String(value).slice(0, 10)}T00:00:00`);

    if (Number.isNaN(date.getTime())) {
        return 'Tanggal belum tersedia';
    }

    return date.toLocaleDateString('id-ID', {
        ...(withWeekday ? { weekday: 'long' } : {}),
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
}

function SectionHeading({ eyebrow, title, description }) {
    return (
        <div className="mb-10">
            <p className="text-xs font-bold tracking-[0.25em] text-cyan-300">
                {eyebrow}
            </p>

            <h2 className="mt-3 text-3xl font-black tracking-tight sm:text-4xl">
                {title}
            </h2>

            <p className="mt-4 max-w-2xl leading-7 text-slate-400">
                {description}
            </p>
        </div>
    );
}

function EmptyState({ title, description }) {
    return (
        <div className="rounded-2xl border border-dashed border-white/15 px-6 py-12 text-center">
            <div className="text-3xl text-slate-500">⌘</div>

            <h3 className="mt-4 text-lg font-bold">{title}</h3>

            <p className="mx-auto mt-2 max-w-lg text-sm leading-6 text-slate-400">
                {description}
            </p>
        </div>
    );
}

function Modal({ children, onClose }) {
    useEffect(() => {
        const handleKeyDown = (event) => {
            if (event.key === 'Escape') onClose();
        };

        document.addEventListener('keydown', handleKeyDown);
        document.body.style.overflow = 'hidden';

        return () => {
            document.removeEventListener('keydown', handleKeyDown);
            document.body.style.overflow = '';
        };
    }, [onClose]);

    return (
        <div
            className="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/75 p-4 backdrop-blur-sm"
            onMouseDown={(event) => {
                if (event.target === event.currentTarget) onClose();
            }}
        >
            <div className="relative my-auto max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl border border-white/10 bg-[#0d1525] p-6 shadow-2xl sm:p-8">
                <button
                    type="button"
                    onClick={onClose}
                    className="absolute right-4 top-4 rounded-lg px-3 py-1 text-xl text-slate-400 hover:bg-white/10 hover:text-white"
                    aria-label="Tutup"
                >
                    ×
                </button>

                {children}
            </div>
        </div>
    );
}

function ConfessionSection() {
    const [confessions, setConfessions] = useState([]);
    const [recipient, setRecipient] = useState('');
    const [message, setMessage] = useState('');
    const [loading, setLoading] = useState(true);
    const [sending, setSending] = useState(false);
    const [notice, setNotice] = useState('');
    const [error, setError] = useState('');

    async function loadConfessions() {
        setLoading(true);
        setError('');

        try {
            const response = await fetch('/confessions-data', {
                headers: { Accept: 'application/json' },
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data Menfess.');
            }

            const data = await response.json();

            setConfessions(
                Array.isArray(data)
                    ? data
                    : Array.isArray(data.data)
                      ? data.data
                      : []
            );
        } catch (err) {
            setError(err.message || 'Gagal memuat Menfess.');
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        loadConfessions();
    }, []);

    async function handleSubmit(event) {
        event.preventDefault();
        setSending(true);
        setNotice('');
        setError('');

        try {
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content');

            const response = await fetch('/confessions-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                },
                body: JSON.stringify({
                    recipient: recipient.trim() || null,
                    message: message.trim(),
                }),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    throw new Error(
                        Object.values(data.errors).flat().join(' ')
                    );
                }

                if (response.status === 419) {
                    throw new Error(
                        'Sesi berakhir. Muat ulang halaman lalu coba lagi.'
                    );
                }

                if (response.status === 429) {
                    throw new Error(
                        'Terlalu banyak mengirim Menfess. Coba lagi nanti.'
                    );
                }

                throw new Error(data.message || 'Menfess gagal dikirim.');
            }

            setRecipient('');
            setMessage('');

            setNotice(
                data.message ||
                    'Menfess berhasil dikirim dan menunggu persetujuan admin.'
            );

            await loadConfessions();
        } catch (err) {
            setError(err.message || 'Terjadi kesalahan.');
        } finally {
            setSending(false);
        }
    }

    return (
        <section
            id="menfess"
            className="scroll-mt-24 border-t border-white/5 bg-[#0b1221] px-5 py-20"
        >
            <div className="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p className="text-xs font-bold tracking-[0.25em] text-cyan-300">
                        RUANG RAHASIA IF 1
                    </p>

                    <h2 className="mt-4 text-4xl font-black sm:text-5xl">
                        Say it
                        <span className="block text-cyan-300">
                            anonymously.
                        </span>
                    </h2>

                    <p className="mt-5 leading-8 text-slate-400">
                        Punya pesan untuk teman sekelas? Mau menyampaikan
                        perasaan, apresiasi, atau sekadar berbagi cerita?
                        Tulis pesanmu di sini.
                    </p>

                    <div className="mt-7 rounded-xl border border-cyan-400/20 bg-cyan-400/5 p-4 text-sm leading-6 text-slate-300">
                        <strong className="text-cyan-300">
                            Tetap jaga kenyamanan bersama.
                        </strong>

                        <p className="mt-1">
                            Hindari menyebarkan data pribadi, ujaran
                            kebencian, perundungan, atau pesan yang merugikan
                            orang lain.
                        </p>
                    </div>

                    <div className="mt-6 flex items-center gap-3 text-sm text-slate-500">
                        <span className="flex h-9 w-9 items-center justify-center rounded-full bg-white/5 text-cyan-300">
                            ↗
                        </span>

                        <span>
                            Pesan yang dikirim dapat memerlukan persetujuan
                            admin sebelum ditampilkan.
                        </span>
                    </div>
                </div>

                <div className="rounded-2xl border border-white/10 bg-[#080d19] p-5 sm:p-7">
                    <h3 className="text-xl font-bold">Kirim Menfess</h3>

                    <p className="mt-2 text-sm text-slate-400">
                        Sampaikan pesanmu dengan sopan.
                    </p>

                    <form onSubmit={handleSubmit} className="mt-6 space-y-5">
                        <div>
                            <label
                                htmlFor="menfess-recipient"
                                className="mb-2 block text-sm font-semibold text-slate-300"
                            >
                                Untuk siapa?{' '}
                                <span className="font-normal text-slate-500">
                                    (opsional)
                                </span>
                            </label>

                            <input
                                id="menfess-recipient"
                                type="text"
                                maxLength={100}
                                value={recipient}
                                onChange={(event) =>
                                    setRecipient(event.target.value)
                                }
                                placeholder="Nama panggilan atau inisial"
                                className="w-full rounded-xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400"
                            />
                        </div>

                        <div>
                            <label
                                htmlFor="menfess-message"
                                className="mb-2 block text-sm font-semibold text-slate-300"
                            >
                                Pesan kamu
                            </label>

                            <textarea
                                id="menfess-message"
                                required
                                minLength={5}
                                maxLength={1000}
                                rows={5}
                                value={message}
                                onChange={(event) =>
                                    setMessage(event.target.value)
                                }
                                placeholder="Tulis pesanmu di sini..."
                                className="w-full resize-y rounded-xl border border-white/10 bg-white/[0.04] px-4 py-3.5 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400"
                            />

                            <p className="mt-2 text-right text-xs text-slate-500">
                                {message.length}/1000 karakter
                            </p>
                        </div>

                        {notice && (
                            <div
                                role="status"
                                className="rounded-xl border border-emerald-400/20 bg-emerald-400/10 p-4 text-sm leading-6 text-emerald-300"
                            >
                                {notice}
                            </div>
                        )}

                        {error && (
                            <div
                                role="alert"
                                className="rounded-xl border border-red-400/20 bg-red-400/10 p-4 text-sm leading-6 text-red-300"
                            >
                                {error}
                            </div>
                        )}

                        <button
                            type="submit"
                            disabled={sending}
                            className="w-full rounded-xl bg-cyan-400 px-5 py-4 font-bold text-slate-950 transition hover:bg-cyan-300 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            {sending ? 'Mengirim...' : 'Kirim Menfess ↗'}
                        </button>
                    </form>

                    <div className="mt-10 border-t border-white/10 pt-7">
                        <div className="flex items-center justify-between gap-3">
                            <h3 className="text-lg font-bold">
                                Menfess terbaru
                            </h3>

                            <button
                                type="button"
                                onClick={loadConfessions}
                                disabled={loading}
                                className="text-xs font-semibold text-cyan-300 hover:text-cyan-200 disabled:opacity-50"
                            >
                                ↻ Muat ulang
                            </button>
                        </div>

                        {loading ? (
                            <p className="mt-5 text-sm text-slate-400">
                                Memuat Menfess...
                            </p>
                        ) : confessions.length === 0 ? (
                            <div className="mt-5 rounded-xl border border-dashed border-white/10 p-6 text-center">
                                <p className="font-semibold">
                                    Belum ada Menfess yang ditampilkan
                                </p>

                                <p className="mt-2 text-sm leading-6 text-slate-500">
                                    Pesan yang sudah disetujui admin akan
                                    muncul di bagian ini.
                                </p>
                            </div>
                        ) : (
                            <div className="mt-5 space-y-4">
                                {confessions.map((item, index) => (
                                    <article
                                        key={item.id || index}
                                        className="rounded-xl border border-white/10 bg-white/[0.03] p-5"
                                    >
                                        <div className="flex items-center gap-3">
                                            <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-cyan-400/10 font-bold text-cyan-300">
                                                ✉
                                            </div>

                                            <div>
                                                <p className="font-semibold">
                                                    {item.recipient ||
                                                        item.penerima ||
                                                        'Untuk seseorang'}
                                                </p>

                                                <p className="text-xs text-slate-500">
                                                    IF 1 • Menfess anonim
                                                </p>
                                            </div>
                                        </div>

                                        <p className="mt-4 whitespace-pre-wrap break-words text-sm leading-7 text-slate-300">
                                            {item.message ||
                                                item.pesan ||
                                                item.content ||
                                                ''}
                                        </p>

                                        {item.created_at && (
                                            <p className="mt-4 text-xs text-slate-500">
                                                {new Date(
                                                    item.created_at
                                                ).toLocaleDateString('id-ID', {
                                                    day: 'numeric',
                                                    month: 'long',
                                                    year: 'numeric',
                                                })}
                                            </p>
                                        )}
                                    </article>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}

createRoot(document.getElementById('app')).render(<App />);
