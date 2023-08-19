import React from 'react';
import { Route, Navigate } from "react-router-dom";

export default function GuardedRoute({ guardFunction, redirectTo, children }) {
  if (guardFunction()) {
    return children;
  }

  return <Navigate to={redirectTo} replace />
}