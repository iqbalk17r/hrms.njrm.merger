import logging
from prodict import Prodict
from whatsapp.models import Outbox, Sent
from django.conf import settings
from django.utils import timezone
from core.models import Datasource
from core.utils import database
import json

logger = logging.getLogger(__name__)

inbox.data = Prodict.from_dict(inbox.data)
if inbox.message_type == "templateButtonReplyMessage":
    sent = Sent.objects.filter(
        pk=inbox.data.message.templateButtonReplyMessage.contextInfo.stanzaId,
        is_interactive=True,
        is_answered=False,
    ).first()
elif inbox.message_type == "listResponseMessage":
    sent = Sent.objects.filter(
        pk=inbox.data.message.listResponseMessage.contextInfo.stanzaId,
        is_interactive=True,
        is_answered=False,
    ).first()
elif inbox.message_type == "extendedTextMessage":
    try:
        sent = Sent.objects.get(
            pk=inbox.data.message.extendedTextMessage.contextInfo.stanzaId,
            is_interactive=True,
            is_answered=False,
        )
    except:
        sent = None  # Sent.objects.filter(session=inbox.session, sent_for=inbox.inbox_by, is_interactive=True, is_answered=False).order_by('sent_date').first()
else:
    sent = None  # Sent.objects.filter(session=inbox.session, sent_for=inbox.inbox_by, is_interactive=True, is_answered=False).order_by('sent_date').first()
if sent is not None:
    sent.properties = Prodict.from_dict(sent.properties)
    if sent.properties.type in [
        "A.I.C","A.I.C.NJRM",
    ]:
        if sent.properties.type == "A.I.C":
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        elif sent.properties.type == "A.I.C.NJRM":
            datasource = Datasource.objects.get(pk="HRMS.NJRM")
        else:
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        
        data = database.fetchone(
            datasource.connection(),
            """
        SELECT 
            trim(c.nodok) as nodok, trim(k.nmlengkap) as nmlengkap, 
            TO_CHAR(c.tgl_mulai, 'DD-MM-YYYY') AS tgl_mulai, 
            TO_CHAR(c.tgl_selesai, 'DD-MM-YYYY') AS tgl_selesai,
            trim(c.status) as status
        FROM sc_trx.cuti_karyawan c
        JOIN sc_mst.karyawan k ON c.nik = k.nik
        WHERE TRUE
            AND nodok = %(objectid)s
        """,
            sent.properties,
        )
        if data is not None:
            if data.status in [
                "A",
            ]:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Terima kasih 🙏\nPengajuan *CUTI* dengan nomor dokumen *{data.nodok}*, atas nama *{data.nmlengkap}* \nPada tanggal: {data.tgl_mulai} - {data.tgl_selesai}\nBerhasil *Disetujui*""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
                database.update(
                    datasource.connection(),
                    """
                UPDATE sc_trx.cuti_karyawan SET
                    status = 'P',
                    approval_by = %(approver)s,
                    approval_date = NOW(),
                    whatsappaccept = TRUE
                WHERE TRUE
                    AND nodok = %(objectid)s
                """,
                    sent.properties,
                )
            else:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Maaf 🙏\nPengajuan *CUTI* dengan nomor dokumen *{data.nodok}*, atas nama *{data.nmlengkap}* \nPada tanggal: {data.tgl_mulai} - {data.tgl_selesai}\n Sudah pernah *Disetujui* sebelumnya""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
    elif sent.properties.type in [
        "A.I.I","A.I.I.NJRM",
    ]:
        if sent.properties.type == "A.I.I":
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        elif sent.properties.type == "A.I.I.NJRM":
            datasource = Datasource.objects.get(pk="HRMS.NJRM")
        else:
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        
        data = database.fetchone(
            datasource.connection(),
            """
        SELECT 
            trim(c.nodok) as nodok, trim(k.nmlengkap) as nmlengkap, 
            TO_CHAR(c.tgl_kerja, 'DD-MM-YYYY') AS tgl_kerja,
            trim(t.uraian) AS jenis_ijin,
            CASE
                WHEN c.type_ijin = 'DN' THEN 'DINAS'
                WHEN c.type_ijin = 'PB' THEN 'PRIBADI'
            END AS tipe_ijin,
            trim(c.status) as status
        FROM sc_trx.ijin_karyawan c
        JOIN sc_mst.karyawan k ON c.nik = k.nik
        JOIN sc_mst.trxtype t ON c.kdijin_absensi = t.kdtrx AND t.jenistrx = 'ABSEN'
        WHERE TRUE
            AND nodok = %(objectid)s
        """,
            sent.properties,
        )
        if data is not None:
            if data.status in [
                "A",
            ]:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Terima kasih 🙏\nPengajuan *IJIN {data.jenis_ijin}* {data.tipe_ijin} dengan nomor dokumen *{data.nodok}*, atas nama *{data.nmlengkap}* \nTanggal: {data.tgl_kerja}\nBerhasil *Disetujui*""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
                database.update(
                    datasource.connection(),
                    """
                UPDATE sc_trx.ijin_karyawan SET
                    status = 'P',
                    approval_by = %(approver)s,
                    approval_date = NOW(),
                    whatsappaccept = TRUE
                WHERE TRUE
                    AND nodok = %(objectid)s
                """,
                    sent.properties,
                )
            else:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Maaf 🙏\nPengajuan *IJIN {data.jenis_ijin}* {data.tipe_ijin} dengan nomor dokumen *{data.nodok}*, atas nama *{data.nmlengkap}* Tanggal: {data.tgl_kerja}\nSudah pernah *Disetujui* sebelumnya""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
    elif sent.properties.type in [
        "A.I.L","A.I.L.NJRM",
    ]:
        if sent.properties.type == "A.I.L":
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        elif sent.properties.type == "A.I.L.NJRM":
            datasource = Datasource.objects.get(pk="HRMS.NJRM")
        else:
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        
        data = database.fetchone(
            datasource.connection(),
            """
        SELECT 
            trim(c.nodok) as nodok, trim(k.nmlengkap) as nmlengkap, 
            TO_CHAR(c.tgl_kerja, 'DD-MM-YYYY') AS tgl_kerja,
            trim(c.status) as status
        FROM sc_trx.lembur c
        JOIN sc_mst.karyawan k ON c.nik = k.nik
        WHERE TRUE 
            AND nodok = %(objectid)s
        """,
            sent.properties,
        )
        if data is not None:
            if data.status in [
                "A",
            ]:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Terima kasih 🙏\nPengajuan *LEMBUR* dengan nomor *{data.nodok}*, atas nama *{data.nmlengkap}* Tanggal: {data.tgl_kerja}\nBerhasil *Disetujui*""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
                database.update(
                    datasource.connection(),
                    """
                UPDATE sc_trx.lembur SET
                    status = 'P',
                    approval_by = %(approver)s,
                    approval_date = NOW(),
                    whatsappaccept = TRUE
                WHERE TRUE
                    AND nodok = %(objectid)s
                """,
                    sent.properties,
                )
            else:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Maaf 🙏\nPengajuan *LEMBUR* dengan nomor *{data.nodok}*, atas nama *{data.nmlengkap}* Tanggal: {data.tgl_kerja}\nSudah pernah *Disetujui* sebelumnya""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
    elif sent.properties.type in [
        "A.I.D","A.I.D.NJRM",
    ]:
        if sent.properties.type == "A.I.D":
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        elif sent.properties.type == "A.I.D.NJRM":
            datasource = Datasource.objects.get(pk="HRMS.NJRM")
        else:
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        
        data = database.fetchone(
            datasource.connection(),
            """
        SELECT 
            trim(c.nodok) as nodok, trim(k.nmlengkap) as nmlengkap, 
            TO_CHAR(c.tgl_mulai, 'DD-MM-YYYY') AS tgl_mulai, 
        	TO_CHAR(c.tgl_selesai, 'DD-MM-YYYY') AS tgl_selesai,
            trim(c.status) as status
        FROM sc_trx.dinas c
        JOIN sc_mst.karyawan k ON c.nik = k.nik
        WHERE TRUE
            AND nodok = %(objectid)s
        """,
            sent.properties,
        )
        if data is not None:
            if data.status in [
                "A",
            ]:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Terima kasih 🙏\nPengajuan *DINAS* dengan nomor dokumen *{data.nodok}*, atas nama *{data.nmlengkap}* \nPada tanggal: {data.tgl_mulai} - {data.tgl_selesai}\nBerhasil *Disetujui*""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
                database.update(
                    datasource.connection(),
                    """
                UPDATE sc_trx.dinas SET
                    status = 'P',
                    approval_by = %(approver)s,
                    approval_date = NOW(),
                    whatsappaccept = TRUE
                WHERE TRUE
                    AND nodok = %(objectid)s
                """,
                    sent.properties,
                )
            else:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Maaf 🙏\nPengajuan *DINAS* dengan nomor dokumen *{data.nodok}*, atas nama *{data.nmlengkap}* \nPada tanggal: {data.tgl_mulai} - {data.tgl_selesai}\nSudah pernah *Disetujui* sebelumnya""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
    elif sent.properties.type in [
        "A.I.S","A.I.S.NJRM",
    ]:
        if sent.properties.type == "A.I.S":
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        elif sent.properties.type == "A.I.S.NJRM":
            datasource = Datasource.objects.get(pk="HRMS.NJRM")
        else:
            datasource = Datasource.objects.get(pk="HRMS.NUSA")
        
        data = database.fetchone(
            datasource.connection(),
            """
        SELECT 
            trim(c.nodok) as nodok, trim(k.nmlengkap) as nmlengkap, 
            trim(sd.nmbarang) as nmbarang, trim(c.status) as status
        FROM sc_trx.sppb_mst c
        JOIN sc_mst.karyawan k ON c.nik = k.nik
        JOIN (select a.branch,a.nodok,a.stockcode,b.nmbarang 
		        from (select branch,nodok,min(stockcode) as stockcode from sc_trx.sppb_dtl
                group by branch,nodok) as a 
                left outer join sc_mst.mbarang b on a.stockcode=b.nodok) as sd on c.nodok=sd.nodok
        WHERE TRUE
            AND c.nodok = %(objectid)s
        """,
            sent.properties,
        )
        if data is not None:
            if data.status in [
                "A",
            ]:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Terima kasih 🙏\nPengajuan *SPPB* *{data.nmbarang}* dengan nomor dokumen *{data.nodok}*, atas nama *{data.nmlengkap}* \nBerhasil *Disetujui*""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
                database.update(
                    datasource.connection(),
                    """
                UPDATE sc_trx.sppb_mst SET
                    status = 'P',
                    approvalby = %(approver)s,
                    approvaldate = NOW(),
                    whatsappaccept = TRUE
                WHERE TRUE
                    AND nodok = %(objectid)s
                """,
                    sent.properties,
                )
            else:
                Outbox.objects.create(
                    message=json.dumps(
                        dict(
                            message=f"""Maaf 🙏\nPengajuan *SPPB* *{data.nmbarang}* dengan nomor dokumen *{data.nodok}*, atas nama *{data.nmlengkap}* \nSudah pernah *Disetujui* sebelumnya""",
                        )
                    ),
                    message_type="conversation",
                    outbox_for=inbox.inbox_by,
                    session=inbox.session,
                )
    else:
        pass
        # Outbox.objects.create(
        #     message=json.dumps(dict(
        #         message=f'''Maaf 🙏. Tidak ada data yang sesuai untuk dikonfirmasi''',
        #     )),
        #     message_type='conversation',
        #     outbox_for=inbox.inbox_by,
        #     session=inbox.session,
        # )
    sent.properties = Prodict.to_dict(sent.properties)
    sent.is_answered = True
    sent.answered_date = timezone.now()
    sent.save()
else:
    pass
    # Outbox.objects.create(
    #     message=json.dumps(dict(
    #         message=f'''Maaf 🙏. Tidak ada data yang sesuai untuk dikonfirmasi''',
    #     )),
    #     message_type='conversation',
    #     outbox_for=inbox.inbox_by,
    #     session=inbox.session,
    # )