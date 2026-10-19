
import React, { useEffect, useState } from 'react';

export default function ConfessionSection() {
    const [confessions, setConfessions] = useState([]);
    const [recipient, setRecipient] = useState('');
    const [message, setMessage] = useState('');
    const [loading, setLoading] = useState(false);
    const [sending, setSending] = useState(false);
    const [error, setError] = useState('');
    const [success, setSuccess] = useState('');

    const fetchConfessions = async () => {
        setLoading(true);
        setError('');

        try {
            const response = await fetch('/confessions-data', {
                headers: {
                    Accept: 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data menfess.');
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
            setError(err.message || 'Terjadi kesalahan saat mengambil menfess.');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchConfessions();
    }, []);

    const handleSubmit = async (event) => {
        event.preventDefault();

        setError('');
        setSuccess('');

        if (message.trim().length < 5) {
            setError('Pesan minimal 5 karakter.');
            return;
        }

        setSending(true);

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
                const validationMessage = data.errors
                    ? Object.values(data.errors).flat().join(' ')
                    : data.message;

                throw new Error(
                    validationMessage || 'Menfess gagal dikirim. Silakan coba lagi.'
                );
            }

            setRecipient('');
            setMessage('');
            setSuccess(
                data.message ||
                'Menfess berhasil dikirim dan menunggu moderasi admin.'
            );
        } catch (err) {
            setError(err.message || 'Terjadi kesalahan saat mengirim menfess.');
        } finally {
            setSending(false);
        }
    };

    return (
        <section
            id="menfess"
            className="scroll-mt-24 bg-slate-950 px-4 py-20 text-white sm:px-6 lg:px-8"
        >
            <div className="mx-auto max-w-6xl">
                <div className="mb-12 text-center">
                    <span className="mb-4 inline-block rounded-full border border-pink-400/30 bg-pink-400/10 px-4 py-2 text-sm font-semibold text-pink-300">
                        💌 Ruang Rahasia IF 1
                    </span>

                    <h2 className="text-3xl font-black tracking-tight sm:text-5xl">
                        Menfess <span className="text-pink-400">IF 1</span>
                    </h2>

                    <p className="mx-auto mt-4 max-w-2xl text-slate-400">
                        Punya pesan, ucapan, atau rahasia yang ingin disampaikan?
                        Kirim menfess untuk teman-teman IF 1.
                    </p>
                </div>

                <div className="grid gap-8 lg:grid-cols-2">
                    <div className="rounded-3xl border border-white/10 bg-white/[0.04] p-6 shadow-xl sm:p-8">
                        <h3 className="mb-2 text-xl font-bold">
                            Kirim Menfess 💗
                        </h3>

                        <p className="mb-6 text-sm leading-6 text-slate-400">
                            Isi pesanmu dengan sopan. Menfess yang dikirim
                            akan menunggu persetujuan admin sebelum ditampilkan.
                        </p>

                        <form onSubmit={handleSubmit} className="space-y-5">
                            <div>
                                <label
                                    htmlFor="recipient"
                                    className="mb-2 block text-sm font-semibold text-slate-200"
                                >
                                    Untuk siapa? (Opsional)
                                </label>

                                <input
                                    id="recipient"
                                    type="text"
                                    value={recipient}
                                    onChange={(event) =>
                                        setRecipient(event.target.value)
                                    }
                                    maxLength={100}
                                    placeholder="Contoh: Teman sekelas..."
                                    className="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-pink-400 focus:ring-2 focus:ring-pink-400/20"
                                />
                            </div>

                            <div>
                                <label
                                    htmlFor="message"
                                    className="mb-2 block text-sm font-semibold text-slate-200"
                                >
                                    Pesan kamu
                                </label>

                                <textarea
                                    id="message"
                                    value={message}
                                    onChange={(event) =>
                                        setMessage(event.target.value)
                                    }
                                    minLength={5}
                                    maxLength={1000}
                                    rows={5}
                                    required
                                    placeholder="Tulis pesanmu di sini..."
                                    className="w-full resize-y rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-pink-400 focus:ring-2 focus:ring-pink-400/20"
                                />

                                <p className="mt-2 text-right text-xs text-slate-500">
                                    {message.length}/1000 karakter
                                </p>
                            </div>

                            {error && (
                                <div
                                    role="alert"
                                    className="rounded-xl border border-red-400/20 bg-red-400/10 p-3 text-sm text-red-300"
                                >
                                    {error}
                                </div>
                            )}

                            {success && (
                                <div
                                    role="status"
                                    className="rounded-xl border border-emerald-400/20 bg-emerald-400/10 p-3 text-sm text-emerald-300"
                                >
                                    {success}
                                </div>
                            )}

                            <button
                                type="submit"
                                disabled={sending}
                                className="w-full rounded-xl bg-pink-500 px-5 py-3 font-bold text-white transition hover:bg-pink-400 disabled:cursor-not-allowed disabled:opacity-60"
                            >
                                {sending ? 'Mengirim...' : 'Kirim Menfess 💌'}
                            </button>
                        </form>
                    </div>

                    <div>
                        <div className="mb-5 flex items-center justify-between gap-4">
                            <div>
                                <h3 className="text-xl font-bold">
                                    Menfess Terbaru
                                </h3>
                                <p className="mt-1 text-sm text-slate-400">
                                    Pesan yang telah disetujui admin.
                                </p>
                            </div>

                            <button
                                type="button"
                                onClick={fetchConfessions}
                                disabled={loading}
                                className="rounded-lg border border-white/10 px-3 py-2 text-sm text-slate-300 transition hover:bg-white/10 disabled:opacity-50"
                            >
                                {loading ? 'Memuat...' : '↻ Refresh'}
                            </button>
                        </div>

                        {loading && confessions.length === 0 ? (
                            <div className="rounded-2xl border border-white/10 bg-white/[0.04] p-8 text-center text-slate-400">
                                Memuat menfess...
                            </div>
                        ) : confessions.length === 0 ? (
                            <div className="rounded-2xl border border-dashed border-white/15 bg-white/[0.03] p-8 text-center">
                                <div className="mb-3 text-4xl">💌</div>
                                <p className="font-semibold text-slate-200">
                                    Belum ada menfess
                                </p>
                                <p className="mt-2 text-sm text-slate-400">
                                    Jadilah yang pertama mengirim pesan!
                                </p>
                            </div>
                        ) : (
                            <div className="max-h-[600px] space-y-4 overflow-y-auto pr-1">
                                {confessions.map((confession) => (
                                    <article
                                        key={confession.id}
                                        className="rounded-2xl border border-white/10 bg-white/[0.04] p-5 transition hover:border-pink-400/30"
                                    >
                                        <div className="mb-3 flex items-center gap-3">
                                            <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-pink-400/10 text-lg">
                                                💌
                                            </div>

                                            <div className="min-w-0">
                                                <p className="font-bold text-pink-300">
                                                    {confession.recipient
                                                        ? `Untuk ${confession.recipient}`
                                                        : 'Pesan Anonim'}
                                                </p>

                                                <p className="text-xs text-slate-500">
                                                    {confession.created_at
                                                        ? new Date(
                                                            confession.created_at
                                                        ).toLocaleDateString(
                                                            'id-ID',
                                                            {
                                                                day: 'numeric',
                                                                month: 'long',
                                                                year: 'numeric',
                                                            }
                                                        )
                                                        : 'Menfess IF 1'}
                                                </p>
                                            </div>
                                        </div>

                                        <p className="whitespace-pre-wrap break-words text-sm leading-7 text-slate-300">
                                            {confession.message}
                                        </p>
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
