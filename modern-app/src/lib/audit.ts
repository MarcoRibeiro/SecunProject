import 'server-only';

import type { Prisma } from '@prisma/client';

import { db } from '@/src/lib/db';

export type AuditLogInput = {
  actorId?: string | null;
  action: string;
  entityType: string;
  entityId?: string | null;
  metadata?: Prisma.InputJsonValue;
  ipAddress?: string | null;
  userAgent?: string | null;
};

const MAX_IP_ADDRESS_LENGTH = 45;
const MAX_USER_AGENT_LENGTH = 255;

function truncateAuditField(value: string | null | undefined, maxLength: number) {
  if (!value) {
    return null;
  }

  return value.trim().slice(0, maxLength) || null;
}

export function normalizeAuditLogInput(entry: AuditLogInput): AuditLogInput {
  return {
    ...entry,
    ipAddress: truncateAuditField(entry.ipAddress, MAX_IP_ADDRESS_LENGTH),
    userAgent: truncateAuditField(entry.userAgent, MAX_USER_AGENT_LENGTH),
  };
}

export async function logAuditEvent(entry: AuditLogInput) {
  const normalizedEntry = normalizeAuditLogInput(entry);

  return db.auditLog.create({
    data: {
      actorId: normalizedEntry.actorId ?? null,
      action: normalizedEntry.action,
      entityType: normalizedEntry.entityType,
      entityId: normalizedEntry.entityId ?? null,
      metadata: normalizedEntry.metadata,
      ipAddress: normalizedEntry.ipAddress ?? null,
      userAgent: normalizedEntry.userAgent ?? null,
    },
  });
}
