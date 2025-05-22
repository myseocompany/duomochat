import pandas as pd
from geopy.geocoders import Nominatim

# Cargar centroides
df = pd.read_csv('zonas_centroides.csv')

# Geolocalizador
geolocator = Nominatim(user_agent="centroides_reverso", timeout=10)

# Obtener barrio/localidad para cada centroide
lugares = []
for i, row in df.iterrows():
    try:
        location = geolocator.reverse((row['latitude'], row['longitude']), exactly_one=True, language='es')
        address = location.raw['address'] if location else {}
        barrio = address.get('neighbourhood', '')
        localidad = address.get('suburb', '') or address.get('city_district', '')
        ciudad = address.get('city', '') or address.get('town', '')
        lugares.append(f"{barrio}, {localidad}, {ciudad}".strip(', '))
    except Exception as e:
        print(f"Error en cluster {i}: {e}")
        lugares.append("No encontrado")

# Añadir y mostrar
df['zona_referente'] = lugares
print("\n📌 Zonas estimadas para cada cluster:")
print(df)

# Exportar
df.to_csv('zonas_centroides_con_nombre.csv', index=False)
