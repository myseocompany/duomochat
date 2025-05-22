import pandas as pd
from sklearn.cluster import KMeans
import matplotlib.pyplot as plt

# Cargar datos
df = pd.read_csv('ordenes_con_coordenadas.csv')

# Filtrar coordenadas válidas
coords = df[['latitude', 'longitude']].dropna()

# KMeans: 5 clusters (puedes ajustar)
k = 5
kmeans = KMeans(n_clusters=k, random_state=42)
coords['cluster'] = kmeans.fit_predict(coords)

# Obtener centroides
centroides = pd.DataFrame(kmeans.cluster_centers_, columns=['latitude', 'longitude'])
centroides['cantidad_pedidos'] = coords['cluster'].value_counts().sort_index().values
centroides.to_csv('zonas_centroides.csv', index=False)

print("\n✅ Clustering completado.")
print("\n📍 Centroides con cantidad de pedidos por zona:")
print(centroides)

# Visualización
plt.figure(figsize=(8, 6))
plt.scatter(coords['longitude'], coords['latitude'], c=coords['cluster'], cmap='tab10', s=15, label='Órdenes')
plt.scatter(centroides['longitude'], centroides['latitude'], color='red', s=100, marker='X', label='Centroides')
plt.title("📦 Clusters de zonas de entrega")
plt.xlabel("Longitud")
plt.ylabel("Latitud")
plt.legend()
plt.grid(True)
plt.show()
