IF(WITH_RYZOM_CLIENT)
  ADD_SUBDIRECTORY(client_patcher)

  IF(WITH_QT OR WITH_QT5)
    ADD_SUBDIRECTORY(client_config_qt)
  ENDIF()

ENDIF()

IF(WITH_QT5 AND WITH_RYZOM_INSTALLER)
  ADD_SUBDIRECTORY(ryzom_installer)
ENDIF()

IF(WITH_RYZOM_TOOLS)
  ADD_SUBDIRECTORY(r2_islands_textures)
ENDIF()
