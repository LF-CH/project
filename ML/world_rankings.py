# -*- coding: utf-8 -*-
"""World_rankings.ipynb

Automatically generated by Colab.

Original file is located at
    https://colab.research.google.com/drive/1_Vw9PWF-CHf1cHoKu5lq_UAlk99KkKNH

# Exploratory Data Analysis

Author: Leah Francis
"""

#Loading in data analysis libraries
import pandas as pd
import numpy as np
import seaborn as sns
import missingno as msno
import matplotlib.pyplot as plt


#Loading in machine learning libraries
from sklearn.preprocessing import StandardScaler
from sklearn.utils import resample
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LogisticRegression
from sklearn.metrics import accuracy_score, precision_score, f1_score, confusion_matrix
from sklearn.model_selection import GridSearchCV
from sklearn.model_selection import cross_val_score
from sklearn.pipeline import Pipeline
from sklearn.compose import ColumnTransformer
from sklearn.preprocessing import StandardScaler, OneHotEncoder
from sklearn.pipeline import Pipeline
from sklearn.model_selection import GridSearchCV
from sklearn.linear_model import LogisticRegression
from sklearn.metrics import classification_report


# Mount Google Drive
from google.colab import drive
drive.mount('/content/drive')

#Loading the dataset into a Pandas dataframe
data = pd.read_csv('/content/drive/MyDrive/world-university-rankings.csv')

#Viewing the first 5 rows of the dataframe
data.head()

# This returns the last five rows of the data frame
data.tail()

data.shape

"""# Univariate Analysis

Summary of statistics
"""

# Display summary statistics of numerical features
summary_stats = data.describe()
print(summary_stats)

"""Distribution of Numerical Features"""

# Plot the distribution of numerical features
numerical_features = ['quality_of_education', 'quality_of_faculty']
for feature in numerical_features:
    plt.figure(figsize=(8, 5))
    sns.histplot(data[feature], kde=True)
    plt.title(f'Distribution of {feature}')
    plt.show()

"""Distribution of Categorical Features"""

# Plot the distribution of categorical features (assuming 'country' is categorical)
plt.figure(figsize=(15, 8))
sns.countplot(x='country', data=data)
plt.title('Distribution of Countries')
plt.xticks(rotation=45)
plt.show()

"""# Multivariate Analysis

Pairplot for Numerical Features
"""

# Pairplot for numerical features
numerical_features = ['quality_of_education', 'quality_of_faculty']
sns.pairplot(data[numerical_features])
plt.show()

"""Correlation Matrix"""

# Calculate and plot the correlation matrix
correlation_matrix = data.corr()
plt.figure(figsize=(10, 8))
sns.heatmap(correlation_matrix, annot=True, cmap='coolwarm', fmt=".2f")
plt.title('Correlation Matrix')
plt.show()

"""Boxplot for Categorical Features"""

# Boxplot for categorical features (assuming 'country' is categorical)
plt.figure(figsize=(15, 8))
sns.boxplot(x='country', y='quality_of_education', data=data)
plt.title('Boxplot of Quality of Education by Country')
plt.xticks(rotation=45)
plt.show()

"""
# Data Preprocessing"""

# Checking for missing values in the dataset
missing_values = data.isnull().sum()

# Displaying the count of missing values for each column
print("Missing Values:")
print(missing_values)

# Handling missing values by replacing them with the mean
mean_broad_impact = data['broad_impact'].mean()
data['broad_impact'].fillna(mean_broad_impact, inplace=True)

# Verifying that there are no more missing values
missing_values_after_handling = data.isnull().sum()
print("Missing Values After Handling:")
print(missing_values_after_handling)

# Defining the features and the transformers for each type of feature
numeric_features = ['quality_of_education', 'quality_of_faculty']
categorical_features = ['institution']

numeric_transformer = Pipeline(steps=[
    ('scaler', StandardScaler())
])

categorical_transformer = Pipeline(steps=[
    ('onehot', OneHotEncoder(handle_unknown='ignore'))
])

# Combining the transformers
preprocessor = ColumnTransformer(
    transformers=[
        ('num', numeric_transformer, numeric_features),
        ('cat', categorical_transformer, categorical_features)
    ])

# Creating a binary column 'Top100' based on 'world_rank'
data['Top100'] = (data['world_rank'] <= 100).astype(int)

# Balancing the Target Variable
data_majority = data[data['Top100'] == 0]
data_minority = data[data['Top100'] == 1]

# Increasing the size of the minority class
data_minority_resampled = resample(data_minority, replace=True, n_samples=len(data_majority), random_state=42)

# Concatenating the resampled minority class with the majority class
balanced_data = pd.concat([data_majority, data_minority_resampled])

# Resetting the index
balanced_data.reset_index(drop=True, inplace=True)

"""# Train-Test Split"""

# Train-Test Split
X = balanced_data.drop('Top100', axis=1)
y = balanced_data['Top100']
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=42)

"""# Model training"""

# Model Training with preprocessor
model = Pipeline(steps=[('preprocessor', preprocessor),
                        ('classifier', LogisticRegression(max_iter=1000, solver='liblinear'))])
model.fit(X_train, y_train)

"""# Model evaluation"""

# Model Predictions
y_pred = model.predict(X_test)

# Performance Metrics

accuracy = accuracy_score(y_test, y_pred)
precision = precision_score(y_test, y_pred)
f1 = f1_score(y_test, y_pred)
conf_matrix = confusion_matrix(y_test, y_pred)

print(f"Accuracy: {accuracy}")
print(f"Precision: {precision}")
print(f"F1 Score: {f1}")
print(f"Confusion Matrix:\n{conf_matrix}")

"""# Visualisations"""

# Confusion Matrix Visualization
sns.heatmap(conf_matrix, annot=True, fmt='g', cmap='Blues')
plt.xlabel('Predicted')
plt.ylabel('Actual')
plt.title('Confusion Matrix')
plt.show()

"""# Model improvements"""

# Define the hyperparameter grid
param_grid = {'classifier__C': [0.001, 0.01, 0.1, 1, 10, 100, 1000], 'classifier__penalty': ['l1', 'l2']}

# Hyperparameter Tuning with Grid Search
grid_search = GridSearchCV(model, param_grid, cv=5)
grid_search.fit(X_train, y_train)

# Get the best model from the grid search
best_model = grid_search.best_estimator_

print("Best Hyperparameters:", grid_search.best_params_)

"""# Validation"""

# Performing k-fold cross-validation (e.g., k=5)
cv_scores = cross_val_score(model, X, y, cv=5)

print("Cross-Validation Scores:", cv_scores)
print("Mean CV Score:", np.mean(cv_scores))

"""# Evaluation"""

# Displaying the classification report
classification_rep = classification_report(y_test, y_pred)
print("Classification Report:\n", classification_rep)

# Count Plot for Selected Columns
selected_columns = ['Top100', 'year', 'country']

for column in selected_columns:
    plt.figure(figsize=(12, 6))
    sns.countplot(x=column, data=balanced_data)
    plt.title(f'Count Plot for {column}')
    plt.xticks(rotation=45)
    plt.show()